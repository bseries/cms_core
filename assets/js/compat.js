define(['jquery', 'versioncompare', 'modernizr', /* 'html5shiv', */ 'domready!'],
function($, versionCompare, Modernizr) {
  var all = [];

  /* ----- Browserswitch  ----- */
  $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
  var old = false;

  old = App.debugCompat;
  old = old || $.browser.msie && versionCompare($.browser.version, '8.0') < 0;
  old = old || $.browser.mozilla && versionCompare($.browser.version, '1.9.2') < 0;

  url = '/browser';
  if (old && window.location != url) {
    var browser = function() {
        window.location = url;
        return; // No further script execution.
    };
    all.push(browser);
  }

  /* ----- Placeholder ----- */
  // if (!Modernizr.placeholder) {
  //   var placeholder = function() {
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
  //   all.push(placeholder);
  // }

  if (!Modernizr.inputtypes.date) {
    var polyfill = function() {
      require(['input-date', 'moment'], function(P, moment) {
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
    all.push(polyfill);
  }
  // Test(window.XMLHttpRequest && (new XMLHttpRequest().sendAsBinary || (window.Uint8Array && window.ArrayBuffer)))
  if (!XMLHttpRequest.prototype.sendAsBinary) {
    var sendAsBinary = function() {
      require(['send-as-binary']);
    };
    all.push(sendAsBinary);
  }

  return {
    run: function() {
      $(all).map(function(k, item) {
        item();
      });
    }
  };
});
