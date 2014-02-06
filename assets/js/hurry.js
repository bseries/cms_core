/*!
 * Hurry
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

(function(window, $) {
  'use strict';

  var Hurry = {};

  function Slideshow(options) {
    var _this = this;

    // The element which receives events when new slides
    // are added to the stage. Should wrap the stage element.
    //
    // slideshow:changed
    // slideshow:add
    this.container = undefined;

    // The element where slides will be inserted to.
    this.stage = undefined;

    this.restartDelay = 750;

    // How long in ms we should wait until advancing to the next
    // slide when using a time (i.e. via start).
    //
    // Should not be less then transition duration
    // when animating a single slide.
    this.advanceSpeed = 2000;

    // Indicates if we should loop around when
    // reaching the last/first slide.
    this.loop = true;

    this.slides = new SlideSequence();

    // Holds the current active interval id.
    this.interval = undefined;

    // How many slides ahead should be inserted and preloaded. All
    // other will be lazily added and load when added.
    this.preload = 1;

    // Asks for new data, then adds a new item to the sequence. Used
    // when sequence is draining allows slideshow to lazily load
    // an infinite number of slides.
    //
    // Holds a function provided by the user to request
    // next slides data. May either be a promise that is
    // resolved passing the data or the data itself. In
    // any case it is wrapped during init to normalize behavior.
    this.requestSlide = undefined;

    // Initializer, must be called and waited for to succeed prior using any of
    // of the other methods provided by this class.
    this.init = function(container, stage, options) {
      _this.container = $(container);
      _this.stage = $(stage);

       options = $.extend({
        restartDelay: _this.restartDelay,
        advanceSpeed: _this.advanceSpeed,
        requestSlide: undefined,
        loop: _this.loop,
        preload: _this.preload
      }, options);

      _this.restartDelay = options.restartDelay;
      _this.advanceSpeed = options.advanceSpeed;
      _this.loop = options.loop;
      _this.preload = options.preload;

      _this.requestSlide = function(skipPreload) {
        var op = options.requestSlide();
        var dfr;

        if (!op) {
          return (new $.Deferred()).reject();
        }

        if (typeof op.then === 'function') {
          // Is deferred or promise.
          dfr = op.done(function(data) {
            _this.add(data);
          });
        } else {
          // Is javascript object.
          _this.add(op);
          dfr = (new $.Deferred()).resolve();
        }
        if (!_this.preload || skipPreload) {
          return dfr;
        }

        dfr.done(function() {
          // Preloading does not need to signal
          // back to the main deferred. This is
          // an optional async opteration.
          var req = (new $.Deferred()).resolve();
          for (var i = 0; i < _this.preload; i++) {
            /* jshint ignore:start */
            req = req.done(function() {
              _this.requestSlide(true);
            });
            /* jshint ignore:end */
          }
        });
        return dfr;
      };

      // Show initial slide and preload more if needed.
      return _this.requestSlide();
    };

    // Adds one slide to the slideshow manually without using
    // requestSlide..
    this.add = function(data) {
      // Allows data to overwrite and add properties to item; also adds
      // a reference to the item's element by selector or content.
      var item = $.extend(new Slide(), data, {
        element: $(data.selector || data.content)
      });

      // Bind helper classes for animation to slide.
      item.element.on('slide:activate', function() {
        $(this).addClass('active');
        $(this).removeClass('deactivating');
      });
      item.element.on('slide:deactivate', function() {
        $(this).removeClass('active');
        $(this).addClass('deactivating');
      });
      item.element.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function() {
        // FIXME Find out why we can't get a ref to the element.
        _this.stage.find('.deactivating').removeClass('deactivating');
      });

      // Order matters; allow item to get an index
      // set before inserting it.
      this.slides.push(item);
      // Inserting an item will force it to be preloaded.
      item.insert(_this.stage);
      _this.container.trigger('slideshow:add', item);
      return true;
    };

    // Changes slideshow to given slide using type next, seek or prev.
    this.change = function(type, index) {
      var next,
          current,
          prev;

      current = _this.slides.get(_this.stage.find('.active').data('slide-index'));
      _this.slides.seek(current.index);

      // First: try to request new internal state.
      var req = new $.Deferred();

      if (type === 'prev') {
        next = _this.slides.prev();
      } else if (type === 'seek') {
        next = _this.slides.seek(index);
      } else {
        next = _this.slides.next();
      }

      if (next) {
        req.resolve();
      } else {
        // First: try to insert more slides and see if that fixes it.
        // Can't and shouldn't request old slides.

        if (type === 'prev') {
          req.reject();
        } else if (type === 'seek' && index < _this.slides.key()) {
          req.reject();
        } else if (type === 'seek') {
          // Calculate how many slides would need to be inserted to
          // get to the seek index.

          // i.e. current index is 10 and requested index is 20
          // we than need to call requestSlide 10 times to add 10 items.

          // Chains deferreds and creates a queue, replacing the
          // returned deferred above. The requests must fire
          // sequentially as otherwise the order of the sequence would become
          // incorrect.
          //
          // Should one of the requests fail the returned deferred also fails.
          for (var i = _this.slides.key(); i < index; i++) {
            // FIXME Is this requesting +1 slide?
            req = req.done(_this.requestSlide);
          }
          req.done(function() {
            _this.slides.seek(index);
          });
        } else {
          req = _this.requestSlide();
          req.done(function() {
            _this.slides.next();
          });
        }
      }

      // Second: if cannot go to slide check if we can wrap around.
      var loop = new $.Deferred();

      req.fail(function() {
        if (_this.loop) {
          if (type === 'prev') {
            _this.slides.end();
          } else if (type === 'seek') {
            // loop.reject();
            throw new Error('Invalid seek index ' + index + '.');
          } else {
            _this.slides.rewind();
          }
          loop.resolve();
        } else {
          req.fail(loop.reject);
        }
      });
      req.done(loop.resolve);

      // Third: actually navigate and show new slide.
      loop.done(function() {
        // Current has never changed; next could have been changed in process.
        next = _this.slides.current();

        // console.debug('changing  with ' + current.index + '->' + next.index);

        var requestFrame = window.requestAnimationFrame || function(callback) { callback(); };
        requestFrame(function() {


          current.element.trigger('slide:deactivate'); // :(
          next.element.trigger('slide:activate'); // :)
          next.element.trigger('slide:showing');

          // Signal that we reached the last slide.
          // This shouldn't happen (except hitting the last slide) if you preload correctly.
          if (!_this.slides.peek(next.index + 1)) {
            _this.container.trigger('slideshow:drain');
            // _this.container.trigger('slideshow:last');
          }

          _this.container.trigger('slideshow:changed', [type, index, current, next]);
        });
      });
    };

    // Pauses the animation of the slideshow.
    this.pause = function() {
      _this.container.addClass('paused');
      clearInterval(_this.interval);
    };

    // Resumes the paused animation of the slideshow.
    this.resume = function() {
      _this.container.removeClass('paused');

      setTimeout(function() {
        _this.change('next', null, true);

        if (_this.interval) {
          clearInterval(_this.interval);
        }
        _this.interval = setInterval(function() {
          _this.change('next', null, true);
        }, _this.advanceSpeed);
      }, _this.restartDelay);
    };

    // Starts animation of slideshow.
    this.start = function() {
      _this.container.removeClass('stopped');

      if (_this.interval) {
        clearInterval(_this.interval);
      }
      _this.interval = setInterval(function() {
        _this.change('next', null, true);
      }, _this.advanceSpeed);
    };

    // Stopps animation of slideshow.
    this.stop = function() {
      _this.container.addClass('stopped');
      clearInterval(_this.interval);
    };

    // Shortcut to change to next slide.
    this.next = function() {
      _this.change('next', null, false);
    };

    // Shortcut to change to previous slide.
    this.prev = function() {
      _this.change('prev', null, false);
    };

    // Shortcut to change slide seeking to specified index.
    this.seek = function(index) {
      _this.change('seek', index, false);
    };
  }

  // Represents a seek'able sequence of slides.
  function SlideSequence() {
    var _this = this;

    this.data = [];

    this._current = 0;

    this.count = 0;

    this.push = function(item) {
      _this.count++;

      item.index = _this.count - 1;

      item.element.data('slide-index', item.index);

      _this.data.push(item);
    };

    this.end = function() {
      _this._current = _this.count - 1;
    };

    this.rewind = function() {
      _this._current = 0;
    };

    this.key = function() {
      return _this._current;
    };

    this.current = function() {
      return _this.get(_this._current);
    };

    this.seek = function(index) {
      if (index in _this.data) {
        _this._current = index;
        return _this.current();
      }
    };

    this.peek = function(index) {
      if (index in _this.data) {
        return _this.data[index];
      }
    };

    this.next = function() {
      var index = _this._current + 1;

      if (index in _this.data) {
        _this._current++;
        return _this.current();
      }
    };

    this.prev = function() {
      var index = _this._current - 1;

      if (index in _this.data) {
        _this._current--;
        return _this.current();
      }
    };

    this.get = function(index) {
      if (index > _this.count - 1 || index < 0) {
        return false;
      }
      return _this.data[index];
    };
  }

  // Represents a single slide.
  function Slide() {
    var _this = this;

    this.index = undefined;

    this.element = undefined;

    this.inserted = false;

    this.insert = function(stage) {
      if (!_this.inserted) {
        stage.append(_this.element);
      }
      _this.inserted = true;
    };

    this.remove = function() {
      _this.element.detach();
      _this.inserted = false;
    };
  }

  // Export objects under Hurry namespace.
  window.Hurry = {
    Slideshow: Slideshow,
    SlideSequence: SlideSequence,
    Slide: Slide
  };
}(window, jQuery));
