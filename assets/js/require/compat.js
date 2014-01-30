define('compat', function(module) {
  var normalize = function(name, normalize) {
    return normalize(name);
  };

  var load = function(name, req, onload) {
    req(['compatManager'], function(Manager) {
      Manager.run([
        name
      ]).done(onload);
    });
  };

  return {
    load: load,
    normalize: normalize
  };
});
