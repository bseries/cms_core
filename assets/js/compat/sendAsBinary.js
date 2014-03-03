/*!
 * Send As Binary Polyfill
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * Licensed under the BSD 3-Clause License.
 * http://opensource.org/licenses/bsd-3-clause
 */
XMLHttpRequest.prototype.sendAsBinary = function (data) {
  ui8a = new Uint8Array(data.length);
  for (var i = 0; i < data.length; i++) {
    ui8a[i] = (data.charCodeAt(i) & 0xff);
  }
  this.send(ui8a.buffer);
};

