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
define(['jquery', 'thingsLoaded'], function($, ThingsLoaded) {

  function FrameByFrameAnimation() {
    var _this = this;

    this.element = null;

    this.totalFrames = 0;

    this.frames = [];

    this.fps = 0;

    // this.duration = 0;

    // The current frame.
    this.currentFrame = 0;

    this.paused = true;

    this.loop = true;

    this.url = function(frame) {};

    this.init = function(element, options) {
      this.element = $(element);

      this.fps = options.fps;
      this.totalFrames = options.totalFrames;
      this.currentFrame = options.currentFrame;

      this.url = options.url;

      for (var i = 0; i < _this.totalFrames; i++) {
        var frame = new Frame();

        if (i == _this.currentFrame) {
          frame.active = true;
        }
        frame.index = i;
        frame.url = _this.url(i);

        frame.preload();
        _this.frames.push(frame);
      }
    };

    this.start = function() {
      this.paused = false;

      var currentTime = this.rightNow();

      (function nextloop(time) {
        var delta = (time - currentTime) / 1000;

        _this.currentFrame += (delta * _this.fps);
        var frameNum = Math.floor(_this.currentFrame);

        if (frameNum >= _this.totalFrames) {
          _this.currentFrame = frameNum = 0;
        }
        requestAnimationFrame(nextloop);

        var frame = _this.frames[frameNum];
        _this.element.attr('src', frame.url);

        currentTime = time;
      })(currentTime);
    };

    this.pause = function() {
      this.paused = true;
    };

    this.stop = function() {
      this.paused = true;
      this.currentFrame = 0;
    };

    this.rightNow = function() {
      /* jshint ignore:start */
      if (window['performance'] && window['performance']['now']) {
        return window['performance']['now']();
      } else {
        return +(new Date());
      }
      /* jshint ignore:end */
    };

    this.animLoop = function() {
    };
  }

  function Frame() {
    var _this = this;

    this.index = undefined;

    this.preloaded = false;

    this.url = null;

    this.active = false;

    // Will preload as element is inserted into DOM.
    this.preload = function() {
      if (_this.preloaded) {
        return (new $.Deferred()).resolve();
      }
      var preloader = new ThingsLoaded.ImagePreloader();

      preloader.addUrl(_this.url);
      var result = preloader.run();

      return result.always(function() {
        _this.preloaded = true;
      });
    };
  }

  return FrameByFrameAnimation;
});
