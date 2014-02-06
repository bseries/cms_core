/*!
 * InputDate - Polyfill for the HTML5 date input type.
 *
 * Copyright (c) 2013-2014 David Persson (http://nperson.de)
 *
 * Licensed under the BSD 3-Clause License.
 * http://opensource.org/licenses/bsd-3-clause
 */
(function($) {
  var self = this;

  // Input placeholder; can be either a string or a function returning a string. To
  // disable setting a placeholder on the input set this here to `false`.
  this.placeholder = 'mm/dd/yyyy';

  // Input pattern; can be either a string or a function returning a string. To
  // disable setting a pattern on the input set this here to `false`.
  this.pattern = '[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}';

  // Localizes a given date string; i.e. turns `2013-10-30` into `10/30/2013`.
  this.localize = function(value) {
    var parsed = Date.parse(value);

    if (isNaN(parsed)) {
      return value;
    }
    var date = new Date(parsed);
    return (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
  };

  // Converts a given date string into its canonical form;
  // i.e. from `10/30/2013` to `2013-10-30`.
  this.canonicalize = function(value) {
    var regex = /^(\d{,2})\/(\d{,2})\/(\d{4})$/;
    var matches = value.match(regex);

    if (matches === null) {
      return value;
    }
    var date = new Date(matches[3], matches[1] - 1, matches[2]);
    return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
  };

  // Localizes the values of the input selected by a given selector and
  // attaches an event handler to the enclosing form in order to canonicalize
  // the values back on form submit.
  this.make = function(selector) {
    var el = $(selector);

    var setting = function(object) {
      if (typeof object == 'string') {
        return object;
      }
      return object && object();
    };
    var placeholder = setting(self.placeholder);
    var pattern = setting(self.pattern);

    if (placeholder) {
      el.attr('placeholder', placeholder);
    }
    if (pattern) {
      el.attr('pattern', pattern);
    }

    el.each(function(k, el) {
      el.value = self.localize(el.value);
    });

    el.parents('form').on('submit', function(ev) {
      el.removeAttr('pattern');
      el.each(function(k, el) {
        el.value = self.canonicalize(el.value);
      });
    });
  };

  // Make global.
  window.inputDate = this;
})(jQuery);
