/*!
 * Bureau Core
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

var App = {
  'debugCompat': false
};

App.env = {
  'project': {
    'version': 'REV'
  }
};

requirejs.config({
  baseUrl: 'http://assets.' + window.location.hostname + '/v' + App.env.project.version,
  waitSeconds: 15,
  paths: {
    'jquery': 'core/js/jquery',
    'underscore': 'core/js/underscore',
    'notify': 'core/js/notify',
    'domready': 'core/js/domready',
    'editor': 'core/js/editor',
    'wysihtml5': 'core/js/wysihtml5',
    'globalize': 'core/js/globalize',
    'modernizr': 'core/js/modernizr',
    'modal': 'core/js/modal',
    'nprogress': 'core/js/nprogress'
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

require(['jquery', 'nprogress', 'domready!'], function($, progress) {
  progress.configure({
    showSpinner: false
  });
  $(document).on('modal:loading', function() {
    progress.start();
  });
  $(document).on('modal:content', function() {
    progress.done();
  });
  $(document).on('modal:ready', function() {
    progress.remove();
  });
});

