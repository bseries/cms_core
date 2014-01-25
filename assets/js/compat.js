/*!
 * Compat Main Control Script
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
define(['jquery', 'underscore', 'versioncompare', 'modernizr', 'domready!'],
function($, _, versionCompare, Modernizr) {
  var all = [];

  /* ----- Browserswitch  ----- */
  // We split browsers into groups of HTML5 (modern) and HTML4 (legacy).
  // Assignment to one group or another is done by using feature detection.
  //
  // This approach replaces the user agent sniffing technique deployed
  // before as that is considered to be bad practice and support for
  // sniffing has been removed from jQuery >= 1.9 already.
  //
  // Modern browsers are:
  //
  // IE9+
  // Firefox 3.5+
  // Opera 9+ (and probably further back)
  // Safari 4+
  // Chrome 1+ (I think)
  // iPhone and iPad iOS1+
  // Android phone and tablets 2.1+
  // Blackberry OS6+
  // Windows 7.5+ (new Mango version)
  // Mobile Firefox
  // Opera Mobile
  //
  // http://responsivenews.co.uk/post/18948466399/cutting-the-mustard
  var modern = 'querySelector' in document && 'localStorage' in window && 'addEventListener' in window;

  // If debugCompat is set to true, pretend if we are an old browser always.
  // This allows to preview what happens if users of such browsers get here.
  if (App.debugCompat) {
    modern = false;
  }

  url = '/browser';
  if (!modern && window.location != url) {
    all.browser = function() {
        window.location = url;
        return; // No further script execution.
    };
  }

  /* ----- Placeholder ----- */
  // if (!Modernizr.placeholder) {
  //   all.placeholder = function() {
  //     requirejs(['html5placeholder'], function() {
  //       $('input[placeholder]').placeholder({
  //         inputWrapper: '<span class="compat" style="position:relative"></span>',
  //         placeholderCSS: {
  //           'font-size':'11px',
  //           'color':'#bababa',
  //           'position': 'absolute',
  //           'left':'5px',
  //           'top':'-1px',
  //           'overflow-x': 'hidden'
  //         }
  //       });
  //     });
  //   };
  // }

  if (!Modernizr.inputtypes.date) {
    all.inputDate = function() {
      require(['inputDate', 'moment'], function(P, moment) {
        P.pattern = '[0-9]{1,2}.[0-9]{1,2}.[0-9]{4}';
        P.placeholder = 'tt.mm.jjjj';

        P.canonicalize = function(value) {
          var parsed = moment(value, 'DD.MM.YYYY');

          if (!parsed.isValid()) {
             return value;
          }
          return parsed.format('YYYY-MM-DD');
        };
        P.localize = function(value) {
          var parsed = moment(value, 'YYYY-MM-DD');

          if (!parsed || !parsed.isValid()) {
             return value;
          }
          return parsed.format('DD.MM.YYYY');
        };

        P.make('input[type="date"]');
      });
    };
  }

  // Test(window.XMLHttpRequest && (new XMLHttpRequest().sendAsBinary || (window.Uint8Array && window.ArrayBuffer)))
  if (!XMLHttpRequest.prototype.sendAsBinary) {
    all.sendAsBinary = function() {
      require(['sendAsBinary']);
    };
  }

  if (!Modernizr.cssfilters) {
    all.cssFilters = function() {
      window.polyfilter_scriptpath = 'http://assets.' + window.location.hostname + '/core/js/compat/';
      require(['cssFilters']);
    };
  }

  Modernizr.addTest('textwrap', function() {
    var style = document.documentElement.style;
    return (style.textWrap || style.WebkitTextWrap || style.MozTextWrap || style.MsTextWrap || style.OTextWrap);
  });
  if (!Modernizr.textwrap) {
    all.balanceText = function() {
      require(['balanceText']);
      // Script automatically intializes on CSS class .balance-text.
    };
  }

  if (!window.compat) {
    window.compat = {
      applied: []
    };
  }

  return {
    available: function() {
      return _.keys(all);
    },
    run: function(selected) {
      _.each(selected || _.keys(all), function(v) {
        if (all.hasOwnProperty(v) && $.inArray(v, window.compat.applied) === -1) {
          all[v]();
          window.compat.applied.push(v);
        }
      });
    }
  };
});
