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

// Export global App (configuration) object.
var App = {
  env: {
    // debugCompat: false,
    project: {
      version: '__REV__'
    }
  }
};

requirejs.config({
  config: {
    text: {
      // Allow cross-domain requests, server features CORS.
      useXhr: function() { return true; }
    }
  },
  baseUrl: 'http://assets.' + window.location.hostname + '/v:' + App.env.project.version,
  waitSeconds: 15,
  paths: {
    // Basics
    'compat': 'core/js/require/compat',
    'domready': 'core/js/require/domready',
    'text': 'core/js/require/text',
    'async': 'core/js/require/async',
    'goog': 'core/js/require/goog',
    'propertyParser': 'core/js/require/propertyParser',
    'jquery': 'core/js/jquery',
    'jqueryUi': 'core/js/jqueryUi',
    'underscore': 'core/js/underscore',

    // Other
    'notify': 'core/js/notify',
    'editor': 'core/js/editor',
    'editor-media': 'core/js/editor/media',
    'editor-page-break': 'core/js/editor/page-break',
    'wysihtml5': 'core/js/wysihtml5',
    'globalize': 'core/js/globalize',
    'modal': 'core/js/modal',
    'nprogress': 'core/js/nprogress',
    'handlebars': 'core/js/handlebars',
    'thingsLoaded': 'core/js/thingsLoaded',
    'moment': 'core/js/moment',
    'scrollTo': 'core/js/scrollTo',
    'waypoints': 'core/js/waypoints',
    'frameByFrameAnimation': 'core/js/frameByFrameAnimation',
    'animationSequence': 'core/js/animationSequence',
    'sprite': 'core/js/sprite',
    'sprintf': 'core/js/sprintf',
    'hurry': 'core/js/hurry',
    'hammer': 'core/js/hammer',

    // Compat
    'versioncompare': 'core/js/compat/versioncompare',
    'compatManager': 'core/js/compatManager',
    'modernizr': 'core/js/compat/modernizr',
    'cssparser': 'core/js/cssparser',
    'cssFilters': 'core/js/compat/cssFilters',
    'balanceText': 'core/js/compat/balanceText',
    'inputDate': 'core/js/compat/inputDate',
    'sendAsBinary': 'core/js/compat/sendAsBinary',
    'animationFrame': 'core/js/compat/animationFrame',
    'performanceNow': 'core/js/compat/performanceNow'
  },
  shim: {
    // Basics
    'underscore': {
      exports: '_'
    },
    'jquery': {
      exports: '$'
    },
    'jqueryUi': {
      deps: ['jquery'],
      exports: '$'
    },

    // App

    // Other
    'globalize': {
      deps: ['jquery'],
      exports: 'Globalize'
    },
    'globalize.en.messages': {
      deps: ['globalize']
    },
    'globalize.de': {
      deps: ['globalize']
    },
    'globalize.de.messages': {
      deps: ['globalize']
    },
    'notify': {
      deps: ['jquery']
    },
    'wysihtml5': {
      exports: 'wysihtml5'
    },
    'handlebars': {
      exports: 'Handlebars'
    },
    'thingsLoaded': {
      deps: ['jquery'],
      exports: 'ThingsLoaded'
    },
    'waypoints': {
      deps: ['jquery'],
      exports: 'jQuery.fn.waypoint'
    },
    'sprintf': {
      exports: 'window.sprintf'
    },
    'hurry': {
      deps: ['jquery'],
      exports: 'Hurry'
    },

    // Compat
    'modernizr': {
      exports: 'Modernizr',
      deps: ['domready!']
    },
    'versioncompare': {
      exports: 'versionCompare'
    },
    'inputDate': {
      deps: ['jquery', 'domready!'],
      exports: 'inputDate'
    },
    'cssparser': {
      exports: 'CSSParser'
    },
    'cssFilters': {
      deps: ['cssparser', 'domready!']
    },
    'balanceText': {
      deps: ['jquery'],
      exports: 'jQuery.fn.balanceText'
    }
  }
});
require(['jquery', 'notify', 'domready!'],
function($) {
  // Bridge between PHP flash messaging and JS notify.
  var flashMessage = $('#messages').data('flash-message');
  var flashLevel = $('#messages').data('flash-level') || 'neutral';

  if (flashMessage) {
    $.notify(flashMessage, 'notify-level-' + flashLevel);
  }
});

require(['jquery', 'nprogress', 'domready!'],
function($, Progress) {
  Progress.configure({
    showSpinner: false
  });
  $(document).on('modal:isLoading', function() { Progress.start(); });
  $(document).on('modal:newContent', function() { Progress.done(); });
  $(document).on('modal:isReady', function() {
    Progress.done();

    setTimeout(function() {
      Progress.remove();
    }, 500);
  });
  $(document).on('transfer:start', function() { Progress.start(); });
//  $(document).on('transfer:progress', function(ev, data) { Progress.set(data); });
  $(document).on('transfer:done', function(data) { Progress.done(); });
});

require(['jquery', 'domready!'], function($) {
  // var hasTouch = (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch);
  // if (hasTouch) {
  //   $('body').addClass('touch');
  // } else {
    $('body').addClass('no-touch');
  // }
});
