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
require(['jquery', 'domready!'], function($) {

  // Automatically bind media attachment.
  var attachDirect = $('.use-media-attachment-direct');
  var attachJoined = $('.use-media-attachment-joined');

  if (attachDirect.length || attachJoined.length) {
    require(['jquery', 'media-attachment'], function($, MediaAttachment) {
        attachDirect.each(function(k, el) {
          MediaAttachment.direct(el, {endpoints: App.env.media.endpoints});
        });
        attachJoined.each(function(k, el) {
          MediaAttachment.joined(el, {endpoints: App.env.media.endpoints});
        });
    });
  }

  // Automaticlly bind editors.
  var editorElements = $('.use-editor');

  if (editorElements.length) {
    require(['jquery', 'editor', 'editor-media', 'editor-page-break'],
      function($, Editor, EditorMedia, EditorPageBreak) {

        var externalPlugins = {
          media: (new EditorMedia()).init({endpoints: App.env.media.endpoints}),
          'page-break': new EditorPageBreak()
        };

        var pluginsByClasses = function(el) {
          var classes = $(el).attr('class').split(/\s+/);
          var plugins = [];

          $.each(classes, function(k, v) {
            if (v.indexOf('editor-') === -1) {
              return;
            }
            v = v.replace('editor-', '');

            if (v in externalPlugins) {
              plugins.push(externalPlugins[v]);
            } else {
              plugins.push(v);
            }
          });
          return plugins;
        };

        var editor = null;
        editorElements.each(function(k, el) {
          editor = new Editor();
          editor.init($(el).find('textarea'), pluginsByClasses(el));
        });
    });
  }

  // Automatically bind sortables.
  var sortableElement = $('.use-manual-sorting');
  if (sortableElement.length) {
    require(['jquery', 'jqueryUi'],
      function($) {
        sortableElement.sortable({
          placeholder: 'sortable-placeholder',
          items: '> tr',
          update: function(ev, ui) {
            var ids = [];
            sortableElement.find('tr').each(function(k, v) {
              ids.push($(v).data('id'));
            });
            $.ajax({
              type: 'POST',
              // Assumes we are on an index page and can relatively get to the endpoint.
              url: window.location.pathname + '/order',
              data: {'ids': ids},
            }).done(function() {
              $.notify('Sortierung gespeichert.', 'success');
            }).fail(function() {
              $.notify('Speichern der Sortierung fehlgeschlagen.', 'error');
              $.notify('Stellen Sie sicher, dass AdBlock für diese Domain deaktiviert ist.');
            });
          }
        });
    });
  }


});
