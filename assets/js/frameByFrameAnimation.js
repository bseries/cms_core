/*!
 * Frame By Frame Animation
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
define(['jquery', 'thingsLoaded', 'compat'], function($, ThingsLoaded, Compat) {

  Compat.run([
    'animationFrame',
    'performanceNow'
  ]);

  // Features a lay queue which sequentially plays queued
  // animationen sequences while honoring
  // connection frames. Also handles looping.

  function FrameByFrameAnimation() {
    var _this = this;

    // Holds the element (most often a div) which
    // background will be animated. All events
    // will be triggered and received on this element.
    this.element = null;

    // Frames animated per second used in the start function.
    // Equal for all sequences accross full animation. Global value.
    this.fps = 12;

    // Set once initiation is done.
    this.frames = [];

    // jQuery object to use for custom queue.
    this.plays = $({});

    // Indicates if a sequence from the queue
    // is currently being played.
    this.playing = false;

    this.init = function(element, options) {
      this.element = $(element);

      options = $.extend({
        // Function which must generate sheet URl when passed a
        // number of the sheet.
        url: function(sheet) {},
        // Frames animated per second.
        fps: _this.fps,
        // The width of each sprite in a spritesheet
        // given in pixels.
        blocksize: _this.blocksize,
        // Number of total sheets.
        totalSheets: 1
      }, options || {});

      this.fps = options.fps;

      // Make a sequence out of loaded sheets and
      // their frames. Can only run once all are
      // loaded.
      //
      // FIXME Find a (mathematical/CS) better solution for this. One that
      // can make a sequence even if sheets come in asynchronously.

      var sheets = [];
      var dfrs = [];

      for (var i = 0; i < options.totalSheets; i++) {
        sheets[i] = $.extend((new Sheet()), {
          index: i,
          // Resolve URL already here.
          url: options.url(i),
          blocksize: options.blocksize
        });
        dfrs.push(sheets[i].load());
      }

      // Join all sheet loading promises.
      var initiated =  $.when.apply($, dfrs);

      initiated.done(function() {
        $.each(sheets, function(k, sheet) {
          $.each(sheet.frames, function(k, frame) {
            _this.frames.push(frame);
          });
        });
      });

      return initiated;
    };

    // Starts to play a sequence.
    //
    // -- Do not run before initiation is done. --
    //
    // Will push play to queue. When a play is pushed the sequences
    // that lead up the just pushed one will stop looping
    // but each one play until the end until it reaches the just
    // pushed one.
    this.start = function(from, to, loop) {
      from = from || 0;
      to   = to || _this.frames.length - 1;

      // Causes all remaining sequences to stop looping.
      // Sequences will listen on the element for signals.
      // Must come before adding new sequence to queue as
      // otherwise that would be included in draining.
      _this.element.trigger('animation:drain');

      var sequence = new Sequence();

      sequence.init(_this.element, _this.frames.slice(from, to), {
        fps: _this.fps,
        loop: _this.loop
      });

      // Will automatically start playing once sequence queued if
      // it is not already playing another sequence.
      _this.plays.queue(function(next) {
        _this.playing = true;

        sequence.start()
          .done(function() {
            _this.playing = false;
            next();
          });
      });
    };
  }

  // Sheet class which will populate its frames array
  // once its spritesheet has been loaded. Automatically
  // calculates number of total sprites using given
  // blocksize.
  function Sheet() {
    var _this = this;

    this.frames = [];

    this.url = null;

    this.index = undefined;

    this.blocksize = null;

    this.load = function() {
      var checker = new ThingsLoaded.ImageChecker();

      var element = new Image();
      element.src = _this.url;

      checker.addImage(element);
      var run = checker.run();

      run.done(function() {
        var totalFrames = element.width / _this.blocksize;

        for (var d = 0; d < totalFrames; d++) {
          _this.frames.push({
            url: _this.url,
            offset: _this.blocksize * d
          });
        }
      });

      return run;
    };
  }

  function Sequence() {
    var _this = this;

    this.fps = 12;

    this.loop = true;

    this.looped = 0;

    // Holds the current animation frame id in
    // case there is an ongoing animation.
    this.animationFrame = undefined;

    // The current frame number. May be of float type
    // use Math.floor() to get to current frame.
    this.currentFrame = 0;

    this.frames = [];

    this.element = undefined;

    this.drain = false;

    this.init = function(element, frames, options) {
      _this.element = element;
      _this.frames = frames;

      options = $.extend({
        loop: _this.loop,
        fps: _this.fps
      }, options || {});

      _this.fps = options.fps;
      _this.loop = options.loop;

      // Listen on element for signals.
      _this.element.on('animation:drain', function() {
        _this.drain = true;
      });
    };

    this.start = function() {
      var dfr = new $.Deferred();

      // Gets high-resolution timestamp.
      var currentTime = window.performance.now();

      // Will show frame by frame using requestAnimationFrame.
      var next = function next(time) {
        var delta = (time - currentTime) / 1000;
        _this.currentFrame += (delta * _this.fps);

        var frame = _this.frames[Math.floor(_this.currentFrame)];
        if (!frame) {
          _this.looped++;

          // Reset sequence even we might stop, that way we get
          // a clean start - if needed.
          _this.currentFrame = 0;
          frame = _this.frames[0];

          // Will stop looping if in drain mode or loop count has been reached.
          if (_this.drain || (_this.loop !== true && _this.looped >= _this.loop)) {
            // Break out of animation here and signal that we are done to outer code.
            dfr.resolve();
            return;
          }
        }
        _this.animationFrame = requestAnimationFrame(next);
        _this.element.css({
          'background-image': 'url(' + frame.url + ')',
          'background-position': '-' + frame.offset + 'px 0'
        });
        currentTime = time;
      };

      // Kickoff animation loop.
      requestAnimationFrame(next);

      return dfr;
    };
  }

  return FrameByFrameAnimation;
});
