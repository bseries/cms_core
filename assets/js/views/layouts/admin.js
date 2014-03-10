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
require(['jquery'/*, 'moment' */, 'domready!'], function($, moment) {

  //
  // Nested management
  //
  var $nested = $('.use-nested');

  var $nestedAdd = $nested.find('.nested-add');
  $nestedAdd.hide();

  $nested.find('.button.add-nested').on('click', function(ev) {
    ev.preventDefault();
    var $newNested = $nestedAdd.clone().show();

    var key = parseInt(Math.random() * 10000, 10);

    $newNested.find('input').each(function() {
      $(this).attr('name', $(this).attr('name').replace(/\[new\]/, '[' + key + ']'));
    });
    $newNested.insertBefore(this);
  });
  $nested.on('click', '.delete-nested',function(ev) {
    ev.preventDefault();

    var $existing = $(this).parents('.nested-item');
    var $del = $existing.find('[name*=_delete]');

    $existing.fadeOut(function() {
      if ($del.length) {
        $del.val(true);
      } else {
        $existing.remove();
      }
    });
   });

  //
  // Dynamic Title
  //
  var $headTitle = $('head title');
  var $headingTitle = $('h1 .title');
  var $titleInput = $('form input.use-for-title');

  var originalValue = $headingTitle.data('untitled');
  // var originalValue = $headingTitle.text();

  $titleInput.on('keyup', function(ev) {
    var $el = $(this);

    if ($.trim($el.val())) {
      $headingTitle.text($el.val());
      $headTitle.text($headTitle.text().replace(/^[\w\s]+\s\-/, $el.val() + ' -'));
    } else {
      $headingTitle.text(originalValue);
      $headTitle.text($headTitle.text().replace(/^[\w\s]+\s\-/, originalValue + ' -'));
    }
  });

  //
  // Relative dates/times.
  //
  /*
  moment.lang('de');

  $('table .date.modified, table .date.created').each(function(k, v) {
   $(v).find('time').html(moment($(v).find('time').attr('datetime')).fromNow());
   $(v).find('time').addClass('relative');
  });
  */

  //
  // Automatically bind media attachment.
  //
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

  //
  // Automaticlly bind editors.
  //
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

  //
  // Automatically bind sortables.
  //
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
