const $ = require('jquery');

class Nav {
    constructor() {
        $(function() {
            $('.nav-item a').click(function() {
                $(this).closest('.nav').find('.nav-item a').removeClass('active');
                $(this).addClass('active');
            });
        });
    }
}

new Nav();