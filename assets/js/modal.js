/*!
 * Modal
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

define(['jquery', 'domready!'],
function($) {

  var elements = {
    modal: $('#modal'),
    overlay: $('#modal-overlay'),
    controls: $('#modal .controls'),
    content: $('#modal .content'),
    close: $('#modal .controls .close')
  };

  var init = function() {
    bindEvents();
  };

  var loading = function() {
    $(document).trigger('modal:loading');

    elements.controls.hide();
    elements.content.hide();

    elements.overlay.fadeIn(200, function() {
      elements.modal.show();
    });
  };

  var fill = function(content, modalClass) {
    $(document).trigger('modal:content');

     elements.content.html(content);
     elements.modal.addClass(modalClass);
  };

  var ready = function() {
    $(document).trigger('modal:ready');

    elements.overlay.fadeIn(200, function() {
      elements.controls.show();
      elements.modal.show();
      elements.content.show();
    });
  };

  var close = function() {
    elements.modal.fadeOut(100);
    elements.overlay.fadeOut(100);

    elements.content.html('');
    elements.modal.removeClass();
  };

  var bindEvents = function() {
    elements.overlay.click(close);

    elements.close.click(function(e) {
      if (e.button !== 0) {
        return;
      }
      e.preventDefault();
      modalStateClosed();
    });

    /* Close modal on ESC key. */
    $(document).bind('keydown', function(e) {
      if (e.keyCode == 27) {
        close();
      }
      return true;
    });
  };

  return {
    fill: fill,
    ready: ready,
    close: close,
    loading: loading
  };
});

