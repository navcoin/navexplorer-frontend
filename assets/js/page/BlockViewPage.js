const $ = require('jquery');

import Code from "../services/Code";
import ExplorerApi from "../services/ExplorerApi";
import nunjucks from "../services/Nunjucks";

class BlockViewPage {
    constructor() {
        let height = $('.block').data('height')

        this.loadTxs(height)

        let code = new Code();
        code.styldCodeBlocks();
    }

    loadTxs(height) {
        ExplorerApi.get("/block/"+height+"/tx", {}, this.renderTxs.bind(this))
    }

    renderTxs(data) {
        console.log(data);
        nunjucks.render("blocks/txs.html", {data: data.elements}, function(err, html) {
            $('.transaction-list').html(html)
        }.bind(this))
    }
}

$(function() {
    if ($('body').is('.page-block-view')) {
        new BlockViewPage();
    }
});