
var App = {
  'debugCompat': false
};

App.env = {
};

requirejs.config({
  urlArgs: "v=REV",
  baseUrl: '//' + window.location.hostname + '/assets',
  waitSeconds: 15,
  paths: {
    'jquery': 'core/js/jquery',
    'underscore': 'core/js/underscore',
    'notify': 'core/js/notify',
    'domready': 'core/js/domready'
  },
  shim: {
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
    'modernizr': {
      exports: 'Modernizr',
      deps: ['domready!']
    },
    'versioncompare': {
      exports: 'versionCompare'
    },
    'html5placeholder': {},
    'notify': {
      deps: ['jquery']
    },
    'underscore': {
      exports: '_'
    },
    'jquery': {
      exports: '$'
    }
  }
});
require(['jquery', 'notify', 'domready!'], function($) {
  // Bridge between PHP flash messaging and JS notify.
  var flashMessage = $('#messages').data('flash-message');
  var flashLevel = $('#messages').data('flash-level') || 'neutral';

  if (flashMessage) {
    $.notify(flashMessage, 'notify-level-' + flashLevel);
  }
});

