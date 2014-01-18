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
define(['jquery', 'wysihtml5', 'globalize', 'media-explorer-modal'],
function($, wysihtml5, Globalize, MediaExplorerModal) {
  var instances = {};

  var rules = {
    classes: {
      'big': 1,
      'small': 1,
      'beta': 1,
      'gamma': 1
    },
    tags: {
      span: {},
      "big": {
          "rename_tag": "span",
          "set_class": "big"
      },
      "small": {
          "rename_tag": "span",
          "set_class": "small"
      },
      h2: {
        "set_class": "beta",
        "check_attributes": {
          "class": "class"
        }
      },
      h3: {
        "set_class": "gamma",
        "check_attributes": {
          "class": "class"
        }
      },
      div: {
        "check_attributes": {
          "class": "class"
        }
      },
      dl: {},
      dt: {},
      dd: {},
      hr: {},
      blockquote: {},
      strong: { rename_tag: "b" }, // User intends to style visually not semantically.
      b:      {},
      i:      {},
      em:     { rename_tag: "i" }, // User intends to style visually not semantically.
      br:     {},
      p:      {},
      ul:     {},
      ol:     {},
      li:     {},
      a:      {
        check_attributes: {
          href:   'url' // important to avoid XSS
        }
      }
    }
  };

  var _ = function(key) {
    return Globalize.localize(key) || key;
  };

  var renderToolbar = function(id, plugins, advanced) {
    var html = $('' +
    '<div id="' + id + 'Toolbar" class="toolbar" style="display: none;">' +
       '<a data-wysihtml5-command="bold" class="plugin-basic button">' + _('bold') +'</a>' +
       '<a data-wysihtml5-command="italic" class="plugin-basic button">' + _('italic') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" class="plugin-headline button">' + _('H2') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3" class="plugin-headline button">' + _('H3') + '</a>' +
       '<a data-wysihtml5-command="formatInline" data-wysihtml5-command-value="big" class="plugin-size button">' + _('big') + '</a>' +
       '<a data-wysihtml5-command="formatInline" data-wysihtml5-command-value="small" class="plugin-size button">' + _('small') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="blockquote" class="plugin-quote button">' + _('„quote“') + '</a>' +
       '<a data-wysihtml5-command="insertHTML" data-wysihtml5-command-value="<hr/>" class="plugin-line button">―</a>' +
       '<a data-wysihtml5-command="insertUnorderedList" class="plugin-list button">' + _('list') + '</a>' +
       '<a data-wysihtml5-command="createLink" class="plugin-link button">' + _('link') + '</a>' +
       '<a data-wysihtml5-command="undo" class="plugin-history button">' + _('undo') + '</a>' +
       '<a data-wysihtml5-command="redo" class="plugin-history button">' + _('redo') + '</a>' +
       '<div data-wysihtml5-dialog="createLink" style="display: none;">' +
         '<input data-wysihtml5-dialog-field="href" value="http://" class="text" />' +
         '<a data-wysihtml5-dialog-action="save" class="button">' + _('OK') + '</a><a data-wysihtml5-dialog-action="cancel" class="button">' + _('cancel') + '</a>' +
       '</div>' +
     '</div>');

    var builtin = [];
    var external = [];

    $.each(plugins, function(k, plugin) {
      if (typeof plugin === 'string') {
        builtin.push('.plugin-' + plugin);
      } else {
        external.push(plugin);
      }
    });

    html.find('a').not(builtin.join()).remove();

    $.each(external, function(k, plugin) {
        html.append(plugin.toolbar());
    });
    return html;
  };

  var makeEditor = function(elements, plugins, advanced) {
    $.each(plugins, function(k, plugin) {
      if (typeof plugin === 'string') {

      } else {
        rules.classes = $.extend(rules.classes, plugin.classes());
        rules.tags = $.extend(rules.tags, plugin.tags());
        wysihtml5.commands = $.extend(wysihtml5.commands, plugin.commands());
      }
    });

    var id = elements.main.attr('id');

    elements.wrap.addClass('editor');
    elements.main.hide();

    var html = renderToolbar(id, plugins, advanced);
    html = $(html).hide();
    elements.wrap.find('label').after(html);
    html.fadeIn();

    instances[id] = new wysihtml5.Editor(id, {
      toolbar: id + "Toolbar",
      style: false,
      parserRules: rules,
      autoLink: false,
      bodyClassName: null,
      composerClassName: 'composer',
      stylesheets: [
        // skip reset stylesheet
        $('link[href*=css]:eq(1)').attr('href').replace(/(base|admin)/, 'iframe')
      ]
    });
    return instances[id];
  };

  return {
    make: function(selector, plugins, advanced) {
      $(selector).each(function(k, element) {
        var elements = {};
        elements.main = $(element);
        elements.wrap = elements.main.parent();

        var editor = makeEditor(elements, plugins || [], advanced);

        editor.on('load', function() {
          // ...
        });
      });
    }
  };
});
