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
    beck.onClick = function (el, callback = ()=>{beckjs.echo('click event')}) {
        el.addEventListener('click', callback());
    };
    beck.get = function (id){
        return document.getElementById(id);
    };
    beck.getByClass = function (className) {
        return document.getElementsByClassName(className);
    }
})();
