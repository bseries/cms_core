/*!
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
define('util', ['jquery'], function($) {
  return {

    isEmptyElement: function(el) {
      return !$.trim($(el).text());
    },

    // Quadratic images are counted as vertical.
    // If there is an equal number of horizontal
    // and vertical images the result is horizontal.
    isMostlyLandscape: function($els) {
      var horiz = 0;
      var vert = 0;

      $els.each(function(k, v) {
          if ($(v).height() >= $(v).width()) {
            vert++;
          } else {
            horiz++;
          }
      });
      return horiz >= vert;
    },

    stringToInteger: function(value) {
      var result = 1;

      $.each(value.split(''), function(k, v) {
        if (isNaN(v-0)) {
          result = result * value.charCodeAt(k);
        } else {
          result = result * v;
        }
      });
      return result;
    },

    // Return is zero-based.
    wasPicked: function(random, total, current) {
      return (Math.floor(random * total) % total) === current;
    }
  };
});
