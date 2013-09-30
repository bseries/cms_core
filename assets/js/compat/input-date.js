(function($) {
  var self = this;

  this.placeholder = 'mm/dd/yyyy';

  this.pattern = '[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}';

  this.localize = function(value) {
    var parsed = Date.parse(value);

    if (isNaN(parsed)) {
      return value;
    }
    var date = new Date(parsed);
    return (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
  };

  this.canonicalize = function(value) {
    var regex = /^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/;
    var matches = value.match(regex);

    if (matches === null) {
      return value;
    }
    var date = new Date(matches[3], matches[1] - 1, matches[2]);
    return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
  };

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

  window.inputDate = this;
})(jQuery);
