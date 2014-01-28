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

  function FrameByFrameAnimation() {
    var _this = this;

    // Holds the element (most often a div) which
    // background will be animated.
    this.element = null;

    this.fps = 0;

    // Holds the current animation frame id in
    // case there is an ongoing animation.
    this.animationFrame = undefined;

    // The current frame. May be of float type
    // use Math.floor() to get to current frame.
    this.currentFrame = 0;

    this.paused = true;

    this.loop = true;

    // Set once initiation is done.
    this.frames = [];

    // The width of each sprite in a spritesheet
    // given in pixels.
    this.blocksize = 800;

    this.init = function(element, options) {
      this.element = $(element);

      options = $.extend({
        url: function(sheet) {},
        loop: _this.loop,
        fps: _this.fps,
        blocksize: _this.blocksize,
        totalSheets: 1
      }, options || {});

      this.fps = options.fps;
      this.loop = options.loop;

      // Make a sequence out of loaded sheets and
      // their frames. Can only run once all are
      // loaded.
      //
      // FIXME Find a (mathematical/CS) better solution for this. One that
      // can make a sequence even if sheets come in asynchronously.

      var sheets = [];
      var totalSheets = options.totalSheets;
      var dfrs = [];

      for (var i = 0; i < (totalSheets); i++) {
        sheets[i] = $.extend((new Sheet()), {
          index: i,
          url: options.url(i),
          blocksize: options.blocksize
        });
        dfrs.push(sheets[i].load());
      }

      // Join all sheet loading promoises.
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

    // Do not run before initiation is done.
    this.start = function() {
      _this.paused = false;

      var currentTime = window.performance.now();

      var next = function next(time) {
        var delta = (time - currentTime) / 1000;
        _this.currentFrame += (delta * _this.fps);

        var frame = _this.frames[Math.floor(_this.currentFrame)];
        if (!frame) {
          _this.currentFrame = 0;
          frame = _this.frames[0];
        }
        _this.animationFrame = requestAnimationFrame(next);
        _this.element.css({
          'background-image': 'url(' + frame.url + ')',
          'background-position': '-' + frame.offset + 'px 0'
        });
        currentTime = time;
      };
      requestAnimationFrame(next);
    };

    this.pause = function() {
      cancelAnimationFrame(_this.animationFrame);
      this.paused = true;
    };

    this.stop = function() {
      this.paused = true;
      this.currentFrame = 0;
      cancelAnimationFrame(_this.animationFrame);
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


  return FrameByFrameAnimation;
});
