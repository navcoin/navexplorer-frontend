const $ = require('jquery');

import TransactionLoader from "../services/TransactionLoader";
import Code from "../services/Code";


class BlockViewPage {
    constructor() {
        console.log("Block View Page");

        let transactionLoader = new TransactionLoader();
        transactionLoader.loadBlockTransactions();

        let code = new Code();
        code.styldCodeBlocks();
    }
}


$(function() {
    if ($('body').is('.page-block-view')) {
        new BlockViewPage();
    }
});