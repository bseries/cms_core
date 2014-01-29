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
define(['jquery', 'animationSequence', 'sprite'], function($, Sequence, Sprite) {

  // Base class for all frame-by-frame animation clases. Allows for animating sprites.
  // General support for looping, fps and using sprites from multiple spritesheets as
  // sources.
  function Base() {
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
        totalSheets: 1,
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
        sheets[i] = $.extend((new Sprite.Sheet()), {
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

      // Call child classes init method.
      if (_this._init) {
        _this._init(initiated);
      }
      return initiated;
    };
  }

  // Supports just a single sequence, will not play automatically
  // but allows for seeking manually through the sequence.
  function Static() {
    Base.call(this);

    var _this = this;

    this.sequence = undefined;

    this._init = function(dfr) {
      return dfr.done(function() {
        _this.sequence = new Sequence();
        _this.sequence.init(_this.element, _this.frames);
      });
    };

    // Seeks to a frame in the sequence. Relative values
    // like '20%' can be used.
    //
    // -- Do not run before initiation is done. --
    //
    this.seek = function(to) {
      _this.sequence.seek(to);
    };
  }
  Static.prototype = Object.create(Base.prototype);

  // Queues multiple plays when calling the start() method. Honors
  // connection frames and can put sequences into drain mode when
  // a new one is added in order to get to play the newly added
  // sequence as early as possible. Allows for playing sub-sequences.
  function Queued() {
    Base.call(this);

    var _this = this;

    this.plays = $({});

    // Starts to play a sequence.
    //
    // -- Do not run before initiation is done. --
    //
    // When play queuing is enabled, will push play to queue. When a play is
    // pushed the sequences that lead up the just pushed one will stop looping
    // but each one play until the end until it reaches the just pushed one.
    this.start = function(from, to, loop) {
      from = from || 0;
      to   = to || _this.frames.length - 1;

      // Causes all remaining sequences to stop looping.
      // Sequences will listen on the element for signals.
      // Must come before adding new sequence to queue as
      // otherwise that would be included in draining.
      _this.element.trigger('animation:drain');

      var sequence = new Sequence();

      // Make to inclusive.
      sequence.init(_this.element, _this.frames.slice(from, to + 1), {
        fps: _this.fps,
        loop: loop
      });

      // Allows signaling outer listeners if the sequence has been
      // stopped playing or it has been stopped because of drain.
      var dfr = new $.Deferred();

      // Will automatically start playing once sequence queued if
      // it is not already playing another sequence.
      _this.plays.queue(function(next) {
        _this.playing = true;
        sequence.start()
          .done(function() {
            if (sequence.drain) {
              dfr.reject();
            } else {
              dfr.resolve();
            }
            _this.playing = false;
            next();
          });
      });

      return dfr;
    };
  }
  Queued.prototype = Object.create(Base.prototype);

  return {
    Static: Static,
    Queued: Queued
  };
});
