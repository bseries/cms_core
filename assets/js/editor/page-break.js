/*!
 * Editor
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */
define(['jquery', 'wysihtml5'],
function($, wysihtml5) {
  return function EditorPageBreak() {
    var _this = this;

    this.init = function(options) {};

    this.toolbar = function() {
      return '<a data-wysihtml5-command="insertHTML" data-wysihtml5-command-value="<div class=page-break></div>" class="button">' + 'page break' + '</a>';
    };

    this.classes = function() {
      return {
        'page-break': 1
      };
    };

    this.tags = function() {
      return {};
    };

    this.commands = function() {
      return {};
    };
  };
});
