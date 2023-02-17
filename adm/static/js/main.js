const beck = {};
(function(){
    beck.echo = function (msg = "") {
        console.log(msg);
    };
    beck.addEventListener = function (el, eventName, eventHandler, selector) {
        if (selector) {
            const wrappedHandler = (e) => {
                if (e.target && e.target.matches(selector)) {
                    eventHandler(e);
                }
            };
            el.addEventListener(eventName, wrappedHandler);
            return wrappedHandler;
        } else {
            el.addEventListener(eventName, eventHandler);
            return eventHandler;
        }
    };
    beck.get = function (id){
        return document.getElementById(id);
    };
    beck.getByName = function (name) {
        return document.getElementsByName(name);
    }
    beck.getByClass = function (className) {
        return document.getElementsByClassName(className);
    }
    beck.getByTag = function (TagName) {
        return document.getElementsByTagName(TagName);
    }
})();
