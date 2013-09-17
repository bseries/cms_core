/*!
 * Editor
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

define(['jquery', 'wysihtml5', 'globalize'],
function($, wsihtml5, Globalize) {
  var instances = {};

  var rules = {
    classes: {
      'big': 1,
      'small': 1
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
      h3: {},
      h4: {},
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

  var renderToolbar = function(id, advanced) {
    var html = $('' +
    '<div id="' + id + 'Toolbar" class="toolbar" style="display: none;">' +
       '<a data-wysihtml5-command="bold" class="button">' + _('bold') +'</a>' +
       '<a data-wysihtml5-command="italic" class="button">' + _('italic') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3" class="button">' + _('H3') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4" class="button">' + _('H4') + '</a>' +
       '<a data-wysihtml5-command="formatInline" data-wysihtml5-command-value="big" class="button">' + _('big') + '</a>' +
       '<a data-wysihtml5-command="formatInline" data-wysihtml5-command-value="small" class="button">' + _('small') + '</a>' +
       '<a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="blockquote" class="advanced button">' + _('„quote“') + '</a>' +
       '<a data-wysihtml5-command="insertHTML" data-wysihtml5-command-value="<hr/>" class="button">―</a>' +
       '<a data-wysihtml5-command="insertUnorderedList" class="button">' + _('list') + '</a>' +
       '<a data-wysihtml5-command="createLink" class="button">' + _('link') + '</a>' +
       '<a data-wysihtml5-command="undo" class="advanced button">' + _('undo') + '</a>' +
       '<a data-wysihtml5-command="redo" class="advanced button">' + _('redo') + '</a>' +
       '<div data-wysihtml5-dialog="createLink" style="display: none;">' +
         '<input data-wysihtml5-dialog-field="href" value="http://" class="text" />' +
         '<a data-wysihtml5-dialog-action="save" class="button">' + _('OK') + '</a><a data-wysihtml5-dialog-action="cancel" class="button">' + _('cancel') + '</a>' +
       '</div>' +
     '</div>');

    if (!advanced) {
      html.find('.advanced').remove();
    }
    return html;
  };

  var makeEditor = function(elements, advanced) {
    var id = elements.main.attr('id');

    elements.wrap.addClass('editor');

    var html = renderToolbar(id, advanced);
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
        $('link[href*="/base.css"]').attr('href').replace('base', 'iframe')
      ]
    });
    return instances[id];
  };

  return {
    make: function(elements) {
      $(elements).each(function(k, element) {
        var elements = {};
        elements.main = $(element);
        elements.wrap = elements.main.parent();

        var editor = makeEditor(elements);

        editor.on('load', function() {
          // ...
        });
      });
    }
  };
});
