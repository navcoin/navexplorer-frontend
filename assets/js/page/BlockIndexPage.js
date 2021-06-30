import CreateTable from "../services/Table";

const $ = require('jquery');

import NumberFormat from "../services/NumberFormat";
import * as moment from 'moment';

class BlockIndexPage {
    constructor() {
        CreateTable($("#block-list"),
            "/block",
            this.getRowData,
            'blocks/table-row.html',
            {
                size: 20,
                page: 1,
            },
            [],
            [
                {"name": "default", "value": "height:desc", "active": true, default: true},
            ],
            true
        );
    }

    getRowData(data) {
        return {
            hash: data.hash,
            hash_small: data.hash.substring(0, 12) + '...'+ data.hash.slice(-4),
            link: "/block/"+data.height,
            age: moment(data.time).utc().fromNow(),
            time: moment(data.time).utc().format('YYYY-MM-DD HH:mm:ss'),
            height: NumberFormat.format(data.height, false),
            tx_count: data.tx_count,
            stakedBy: data.stakedBy,
            stake: NumberFormat.formatNav(data.stake/100000000)
        }
    }
}


$(function() {
    if ($('body').is('.page-block-index')) {
        new BlockIndexPage();
    }
});