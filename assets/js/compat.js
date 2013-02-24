define(['jquery', 'versioncompare', 'modernizr', 'domReady!'],
function($, versionCompare, Modernizr) {
  var all = [];

  /* ----- Browserswitch  ----- */
  $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
  var old = false;

  old = App.debugCompat;
  old = old || $.browser.msie && versionCompare($.browser.version, '8.0') < 0;
  old = old || $.browser.mozilla && versionCompare($.browser.version, '1.9.2') < 0;

  url = 'http://' + App.env.site.host + '/errors/browser';
  if (old && window.location != url) {
    var browser = function() {
        window.location = url;
        return; // No further script execution.
    };
    all.push(browser);
  }

  return {
    run: function() {
      $(all).map(function(k, item) {
        item();
      });
    }
  }
});


