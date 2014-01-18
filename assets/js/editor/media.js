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
define(['jquery', 'wysihtml5', 'media-explorer-modal'],
function($, wysihtml5, MediaExplorerModal) {
  return function EditorMedia() {
    var _this = this;

    this.mediaExplorerConfig = {
        'selectable': true,
        'endpoints': {
          view: '/files/__ID__'
        }
        // FIXME Restrict to images only.
    };

    this.init = function(options) {
      _this.mediaExplorerConfig = $.extend(_this.mediaExplorerConfig, options || {});
      MediaExplorerModal.init(_this.mediaExplorerConfig);

      return _this;
    };

    // Returns endpoint string; may replace __ID__ placeholder.
    this.endpoint = function(name, id) {
      var item = _this.mediaExplorerConfig.endpoints[name];

      if (name == 'view') {
        return item.replace('__ID__', id);
      }
      return item;
    };

    this.item = function(id) {
      return $.getJSON(_this.endpoint('view', id));
    };

    this.toolbar = function() {
      return '<a data-wysihtml5-command="insertMedia" class="button media-explorer">' + 'media' + '</a>';
    };

    this.classes = function() {
      return {
        'media': 1,
        'image': 1
      };
    };

    this.tags = function() {
      return {
        "img": {
          "check_attributes": {
            "width": "numbers",
            "height": "numbers",
            "title": "title",
            "class": "class",
            "alt": "alt",
            "src": "src",
            "data-media-id": "data-media-id"
          }
        }
      };
    };

    this.commands = function() {
      return {
        insertMedia: {
          exec: function(composer, command, value) {
            var doc = composer.doc;

            MediaExplorerModal.open();

            var insert = function(data) {
              image = doc.createElement('IMG');

              image.setAttribute('src', data.versions.fix1.url);
              image.setAttribute('class', 'media image');
              image.setAttribute('alt', 'image');
              image.setAttribute('title', data.title);
              image.setAttribute('data-media-id', data.id);
              image.setAttribute('data-media-version', 'fix1');

              composer.selection.insertNode(image);
            };

            $(document).one('media-explorer:selected', function(ev, ids) {
              $.each(ids, function(k, id) {
                _this.item(id).done(function(data) {
                  insert(data.file);
                });
              });
              MediaExplorerModal.close();
            });
          },
          state: function(composer) {
            wysihtml5.commands.insertImage.state(composer);
          }
        }
      };
    };
  };
});
