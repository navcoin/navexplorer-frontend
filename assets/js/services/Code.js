const $ = require('jquery');

export default class Code {
    constructor() {
    }

    styldCodeBlocks() {
        $('pre').each(function() {
            try {
                let json = JSON.parse($(this).html());
                $(this).html(
                    Code.syntaxHighlight(JSON.stringify(json, null, 2))
                );
            } catch(e) {
                // console.error(e);
            }
        });
    }

    static syntaxHighlight(json) {
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
}