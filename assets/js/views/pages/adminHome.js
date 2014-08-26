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

require(['jquery', 'widgets', 'domready!'], function($, Widgets) {

  var dfrs = [];

  $('.widget').each(function() {
    var widget = new Widgets[$(this).data('widget-type')](this, $(this).data('widget-name'));
    dfrs.push(widget.render());
  });
  $when.apply($, dfrs).done(function() {
    $('.widgets').removeClass('loading');
  });

});
