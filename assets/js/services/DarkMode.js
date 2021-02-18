const $ = require('jquery');

import Cookies from "js-cookie";

class DarkMode {
    constructor() {
        this.getDarkMode();

        this.addListener();
    };

    getDarkMode() {
        let dm = Cookies.get("dm");

        if (dm == true) {
            let body = $("body");
            body.addClass('dark-mode');
            console.info("We are in dark mode");
        } else {
            Cookies.set("dm", false);
            console.info("We are in light mode");
        }
    };

    addListener() {
        $(function() {
            $('.dark-mode-toggle').click(function (event) {
                console.log("dark mode clicked");
                event.preventDefault();

                let dm = Cookies.get("dm");

                if (dm == true) {
                    let body = $("body");
                    body.removeClass('dark-mode');
                    Cookies.set("dm", false);
                } else {
                    let body = $("body");
                    body.addClass('dark-mode');
                    Cookies.set("dm", true);
                }
            });
        });
    }
}

new DarkMode();