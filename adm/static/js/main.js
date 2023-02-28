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
    };
    beck.getByClass = function (className) {
        return document.getElementsByClassName(className);
    };
    beck.getByTag = function (TagName) {
        return document.getElementsByTagName(TagName);
    };
    let checkCount = 0;
    let listTable = beck.get('list_table');
    let checkAll = beck.get('check_all');
    let checkList = beck.getByName('check-item');
    checkAll.addEventListener('click', function () {
        if (checkAll.checked == false) {
            for (let i = 0; i < checkList.length; i++) {
                checkList[i].checked = false;
                checkList[i].parentNode.parentNode.style.background='';
            }
            checkCount = 0;
        } else {
            for (let i = 0; i < checkList.length; i++) {
                checkList[i].checked = true;
                checkList[i].parentNode.parentNode.style.background='#fdf6e3';
            }
            checkCount = checkList.length;
        }
    });
    listTable.addEventListener('click', function (evt) {
        let el = evt.target;
        if (el.name=='check-item' ) {
            if (el.checked == true) {
                // el.parentNode.parentNode.classList.add('checked');
                el.parentNode.parentNode.style.background='#fdf6e3';
                checkCount++;
            } else {
                el.parentNode.parentNode.style.background='';
                checkCount--;
            }
            console.log(checkCount);
            if (checkCount == checkList.length) {
                checkAll.checked = true;
            }
            else {
                checkAll.checked = false;
            }
        }
    });
})();
