const $ = require('jquery');
const $clamp = require('clamp-js-main');

$('.clamp').each(function () {
    let lines = $(this).data("lines");
    if (lines === undefined) {
        lines = "auto"
    }

    $clamp($(this).get(0), {clamp: lines});
    $(this).addClass("clamp-display")
});