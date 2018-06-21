const $ = require('jquery');

import TransactionLoader from "../services/TransactionLoader";
import Code from "../services/Code";

class TransactionViewPage {
    constructor() {
        console.log("Transaction View Page");

        let transactionLoader = new TransactionLoader();
        transactionLoader.loadBlockTransactions();

        let code = new Code();
        code.styldCodeBlocks();
    }
}


$(function() {
    if ($('body').is('.page-transaction-view')) {
        new TransactionViewPage();
    }
});