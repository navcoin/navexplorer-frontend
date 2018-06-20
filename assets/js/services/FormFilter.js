const $ = require('jquery');

export default class FormFilter {
    constructor() {
        $(function() {
            $(".form-filter input").change(function() {
                let $form = $(this).closest('form');
                let filters = '';
                $form.find('input').each(function() {
                    if ($(this).prop('checked')) {
                        filters += $(this).attr('name') + ',';
                    }
                });
                filters = filters.substring(0, filters.length - 1)
                document.location.href = $form.attr('action')+'?filters='+filters;
            });
        });
    }
}