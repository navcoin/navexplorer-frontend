const $ = require('jquery');

import anchorme from "anchorme";

$('.autolink').each(function () {
    let options = {
        attributes:[
            {
                name:"target",
                value:"_blank"
            }
        ],
        truncate: null,
        middleTruncation: true,
    }

    if ($(this).data('truncate')) {
        options.truncate = $(this).data('truncate')
    }

    $(this).html(
        anchorme($(this).html(), options)
    );
});