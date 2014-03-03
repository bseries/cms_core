/*!
 * Browser Switch
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * Licensed under the BSD 3-Clause License.
 * http://opensource.org/licenses/bsd-3-clause
 */
define([], function() {

  // We split browsers into groups of HTML5 (modern) and HTML4 (legacy).
  // Assignment to one group or another is done by using feature detection.
  //
  // "The Mustard Test"
  //
  // This approach replaces the user agent sniffing technique deployed
  // before as that is considered to be bad practice and support for
  // sniffing has been removed from jQuery >= 1.9 already.
  //
  // 1. legacy browsers (never work, force upgrade)
  // 2. legacy browser, explictly excluded and supported (degraded expirience)
  //
  // If you want to support a legacy browser (IE8) they must be explictely excluded
  // from the redirect and workarounds added elsewhere. If your contract says to
  // support that one browser version you may actually want to fall back to browser
  // sniffing to fullfill the contract to the letter.
  //
  // 3. modern browsers, tested and deemed supported (full expierience)
  // 4. modern browsers, untested (probably work, expierence unknown)
  //
  // When a browser is deemed modern, it doesn't mean it is supported. You must
  // explicitly test the browser and add workarounds where needed.  Don't assume
  // that all modern browsers will just work and use the list below to present
  // compatibility in a contract.
  //
  // Modern browsers are:
  //
  // IE9+
  // Firefox 3.5+
  // Opera 9+ (and probably further back)
  // Safari 4+
  // Chrome 1+ (I think)
  // iPhone and iPad iOS1+
  // Android phone and tablets 2.1+
  // Blackberry OS6+
  // Windows 7.5+ (new Mango version)
  // Mobile Firefox
  // Opera Mobile
  //
  // http://responsivenews.co.uk/post/18948466399/cutting-the-mustard
  var modern = 'querySelector' in document && 'localStorage' in window && 'addEventListener' in window;

  // Users of legacy browsers will by default be redirected to a browser upgrade page.
  var url = '/browser';
  if (!modern && window.location != url) {
    window.location = url;
  }

});
