const $ = require('jquery');

import Code from "../services/Code";

class TransactionViewPage {
    constructor() {
        console.log("Transaction View Page");

        let code = new Code();
        code.styldCodeBlocks();
    }
}


$(function() {
    if ($('body').is('.page-transaction-view')) {
        new TransactionViewPage();
    }
});