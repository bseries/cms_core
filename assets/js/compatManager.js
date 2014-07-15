/*!
 * Compat Manager
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * Licensed under the BSD 3-Clause License.
 * http://opensource.org/licenses/bsd-3-clause
 */
define(['jquery', 'modernizr', 'domready!'],
function($, Modernizr) {

  var CompatManager = (function() {
    // Holds all registered compat modules, keyed
    // by name.
    var all = {};

    // Registers a compat module.
    //
    // The module is identified by its name.
    //
    // It will load when the precondition is true. The precondition
    // argument may either by a callback or a boolean.
    //
    // The load function will receive a promise as its first parameter
    // which must be resolved when the loading finished.
    var register = function(name, precondition, load) {
      all[name] = function(dfr) {
        if (($.isFunction(precondition) && precondition()) || precondition) {
          load(dfr);
        }
      };
    };

    // Returns an array of available compat modules names.
    var available = function() {
        var keys = [];
        $.each(all, function(k, v) { keys.push(k); });
        return keys;
    };

    // Runs the selected or when the first argument is omitted
    // all available compat modules. Returns a promise which
    // will resovle when all compat modules finished loading.
    var run = function(selected) {
      var dfrs = [];

      $.each(selected || available(), function(k, v) {
        var dfr = new $.Deferred();

        if (!all.hasOwnProperty(v)) {
          dfr.reject();
        } else if ($.inArray(v, window.Compat.applied) === -1) {
          all[v](dfr);

          dfr.done(function() {
            window.Compat.applied.push(v);
          });
        } else {
          dfr.resolve();
        }
        dfrs.push(dfr);
      });

      return dfrs ? $.when.apply(dfrs) : (new $.Deferred()).resolve();
    };

    // Global storage for already applied modules.
    if (!window.Compat) {
      window.Compat = {
        applied: []
      };
    }

    return {
      available: available,
      register: register,
      run: run
    };
  })();

  CompatManager.register('inputDate', !Modernizr.inputtypes.date, function(dfr) {
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
      dfr.resolve();
    });
  });

  // Test(window.XMLHttpRequest && (new XMLHttpRequest().sendAsBinary || (window.Uint8Array && window.ArrayBuffer)))
  CompatManager.register('sendAsBinary', !XMLHttpRequest.prototype.sendAsBinary, function(dfr) {
    require(['sendAsBinary'], dfr.resolve);
  });

  CompatManager.register('cssFilters', !Modernizr.cssfilters, function(dfr) {
    window.polyfilter_scriptpath = 'http://assets.' + window.location.hostname + '/core/js/compat/';
    require(['cssFilters'], dfr.resolve);
  });

  CompatManager.register(
    'balanceText',
    function() {
      var style = document.documentElement.style;
      return !(style.textWrap || style.WebkitTextWrap || style.MozTextWrap || style.MsTextWrap || style.OTextWrap);
    },
    function(dfr) {
      require(['balanceText'], dfr.resolve);
      // Script automatically intializes on CSS class .balance-text.
    }
  );

  CompatManager.register('animationFrame', !window.requestAnimationFrame, function(dfr) {
    require(['animationFrame'], dfr.resolve);
  });

  return CompatManager;
});
