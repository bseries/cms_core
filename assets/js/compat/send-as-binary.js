XMLHttpRequest.prototype.sendAsBinary = function (data) {
  ui8a = new Uint8Array(data.length);
  for (var i = 0; i < data.length; i++) {
    ui8a[i] = (data.charCodeAt(i) & 0xff);
  }
  this.send(ui8a.buffer);
};

