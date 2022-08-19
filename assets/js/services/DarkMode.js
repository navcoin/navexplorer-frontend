const $ = require('jquery');

import axios from "axios";

class DarkMode {
    constructor() {
        this.addListener();
    };

    addListener() {
        $(function() {
            $('#blackhole').click(function (event) {
                console.log("dark mode clicked");
                event.preventDefault();

                // Call the endpoint
                axios.post('/dark.json', {})
                    .then(function (res) {
                    if (!res.data.darkmode) {
                        $('#blackhole svg.darkmode').removeClass('d-none')
                        $('#blackhole svg.lightmode').addClass('d-none')
                        $('body').removeClass('dark')
                    } else {
                        $('#blackhole svg.darkmode').addClass('d-none')
                        $('#blackhole svg.lightmode').removeClass('d-none')
                        $('body').addClass('dark')
                    }
                    })
                    .catch(function (error) {
                        console.log(error);

                    });
            });
        });
    }
}

new DarkMode();
