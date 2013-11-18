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
  $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
  var old = false;

  old = App.debugCompat;
  old = old || $.browser.msie && versionCompare($.browser.version, '8.0') < 0;
  old = old || $.browser.mozilla && versionCompare($.browser.version, '1.9.2') < 0;

  url = '/browser';
  if (old && window.location != url) {
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

  // Use CSS class:
  // .balance-text {
  //   text-wrap: balanced;
  // }
  if (!Modernizr.textwrap) {
    require(['balanceText']);
    // Script automatically intializes.
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
