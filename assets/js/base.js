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

requirejs.config({
  config: {
    text: {
      // Allow cross-domain requests, server features CORS.
      useXhr: function() { return true; }
    }
  },
  baseUrl: App.assets.base + '/v:__PROJECT_VERSION_BUILD__',
  waitSeconds: 15,
  paths: {
    // Basics
    'domready': 'cms-core/js/require/domready',
    'text': 'cms-core/js/require/text',
    'async': 'cms-core/js/require/async',
    'propertyParser': 'cms-core/js/require/propertyParser',
    'jquery': 'cms-core/js/jquery',
    'jqueryUi': 'cms-core/js/jqueryUi',
    'router': 'cms-core/js/router',

    // Other
    'util': 'cms-core/js/util',
    'notify': 'cms-core/js/notify',
    'editor': 'cms-core/js/editor',
    'editor-media': 'cms-core/js/editor/media',
    'editor-page-break': 'cms-core/js/editor/page-break',
    'wysihtml5': 'cms-core/js/wysihtml5',
    'modal': 'cms-core/js/modal',
    'nprogress': 'cms-core/js/nprogress',
    'handlebars': 'cms-core/js/handlebars',
    'sortable': 'cms-core/js/sortable',
    'list': 'cms-core/js/list',
    'listPagination': 'cms-core/js/listPagination',

    // Compat
    'modernizr': 'cms-core/js/compat/modernizr',
  },
  shim: {
    'jquery': {
      exports: '$'
    },

    // App (here Admin)
    'notify': {
      deps: ['jquery', 'modernizr']
    },
    'wysihtml5': {
      exports: 'wysihtml5'
    },
    'handlebars': {
      exports: 'Handlebars'
    },
    'list': {
      exports: 'window.List'
    },
    'listPagination': {
      exports: 'window.ListPagination',
      deps: ['list']
    },

    // Compat
    'modernizr': {
      exports: 'Modernizr',
      deps: ['domready!']
    },
  }
});


