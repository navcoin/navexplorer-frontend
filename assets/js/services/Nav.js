const $ = require('jquery');

class Nav {
    constructor() {

        this.setActiveClass();
    };

    setActiveClass() {

        let currentPath = location.pathname;

        $('.nav-item').each(function () {

            let currentItem = $(this);
            let currentLink = currentItem.find('.nav-link');

            if (currentLink.attr('href') === currentPath) {

                currentItem.addClass('active');
            }
        })
    };
}

new Nav();