require(['jquery', 'notify', '!domready'], function($) {
  // Bridge between PHP flash messaging and JS notify.
  var flashMessage = $('#messages').data('flash-message');
  var flashLevel = $('#messages').data('flash-class');
  if (flashMessage) {
    $.notify(flashMessage, 'notify-level-' + flashLevel);
  }
});

