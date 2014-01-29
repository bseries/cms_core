/*!
 * Sprite
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
define(['jquery', 'thingsLoaded'], function($, ThingsLoaded) {

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

    // FIXME Force browser to prerender image
    // on screen just preloading isn't enough.
    // Check if it is enough to set insert image in DOM
    // or set background on DOM element or must set
    // background on element itself. Browsers are
    // pretty eager with drawing.
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

  return {
    Sheet: Sheet
  };
});
