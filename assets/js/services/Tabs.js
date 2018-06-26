const $ = require('jquery');

class Tabs {
    constructor() {
        $(function() {
            $('.nav-item a').click(function() {
                $(this).closest('.nav').find('.nav-item a').removeClass('active');
                $(this).addClass('active');
            });
        });
    }
}

new Tabs();