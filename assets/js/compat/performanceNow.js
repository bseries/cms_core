(function() {

    if(window.performance && window.performance.now) return;

    if(!window.performance) window.performance = {};

    var methods = ['webkitNow', 'msNow', 'mozNow'];

    for(var i = 0; i < methods.length; i++) {
        if(window.performance[methods[i]]) {
            window.performance.now = window.performance[methods[i]];
            return;
        }
    }

    if(Date.now) {
        window.performance.now = function() {
            return Date.now();
        };
        return;
    }

    window.performance.now = function() {
        return +(new Date());
    };

})();