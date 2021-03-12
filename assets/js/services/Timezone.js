const $ = require('jquery');

import * as moment from 'moment';

class Timezone {
    constructor() {
        $(function() {
            $('.date-localised').each(function() {
                // $(this).html(moment($(this).data('timestamp')).format('MMM[&nbsp;]Do[&nbsp;]YYYY, h:mm:ss[&nbsp;]a'));
            });
        });
    }
}

new Timezone();