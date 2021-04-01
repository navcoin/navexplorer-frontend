let nunjucks = require("nunjucks");

nunjucks.configure("/templates", {
    web: {
        useCache: true,
        async: true
    },
    autoescape: false,
});

export default nunjucks;