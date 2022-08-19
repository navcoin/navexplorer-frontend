const $ = require('jquery');

import Cookies from "js-cookie";

class DarkMode {
    constructor() {
        if (Cookies.get('darkmode')) {
            // Touch the cookie to make it live longer
            Cookies.set('darkmode', true, { expires: 365 });
        }

        this.addListener();
    };

    addListener() {
        $(function() {
            $('#blackhole').click(function (event) {
                event.preventDefault();

                let darkmode = Cookies.get('darkmode');

                if (darkmode) {
                    $('#blackhole svg.darkmode').removeClass('d-none')
                    $('#blackhole svg.lightmode').addClass('d-none')
                    $('body').removeClass('dark')
                    // Remove the cookie
                    Cookies.remove('darkmode');
                } else {
                    $('#blackhole svg.darkmode').addClass('d-none')
                    $('#blackhole svg.lightmode').removeClass('d-none')
                    $('body').addClass('dark')
                    // Set the cookie to expire in about 1 year
                    Cookies.set('darkmode', true, { expires: 365 });
                }
            });
        });
    }
}

new DarkMode();
