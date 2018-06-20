const $ = require('jquery');

import TransactionLoader from "../services/TransactionLoader";

class BlockViewPage {
    constructor() {
        console.log("Block View Page");

        let transactionLoader = new TransactionLoader();
        transactionLoader.loadBlockTransactions();
    }
}


$(function() {
    if ($('body').is('.page-block-view')) {
        new BlockViewPage();
    }
});