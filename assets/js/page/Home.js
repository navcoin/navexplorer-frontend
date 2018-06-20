const $ = require('jquery');

class PageHome {
    constructor()
    {
        console.log("Home Page");
    }
}

if ($('body').is('.page-home')) {
    new PageHome();
}