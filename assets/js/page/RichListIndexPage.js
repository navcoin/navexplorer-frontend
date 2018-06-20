const $ = require('jquery');

import Distribution from "../services/Distribution";

class RichListIndexPage {
    constructor() {
        console.log("Rich List Index Page");

        let wealthDistribution = new Distribution('#wealthDistribution', '/distribution/balance.json');
    }
}


$(function() {
    if ($('body').is('.page-richList-index')) {
        new RichListIndexPage();
    }
});