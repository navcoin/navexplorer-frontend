const $ = require('jquery');

import NumberFormat from "../services/NumberFormat";
import * as moment from 'moment';
import CreateTable from '../services/Table';

class TransactionIndexPage {
    constructor() {
        CreateTable($("#transaction-list"),
            "/tx",
            this.getRowData,
            'transactions/table-rows.html',
            {
                sort: [
                    { txheight: "desc" },
                    { index: "asc" },
                ],
                size: 20,
                page: 1,
            },
            [
                {
                    "field": "type",
                    "name": "Tx Type",
                    "primary": true,
                    "filters": [
                        {"name": "all", "value": "coinbase|staking|cold_staking|cold_staking_v2|transfer|spend", "active": true, default: true},
                        {"name": "coinbase", "value": "coinbase"},
                        {"name": "staking", "value": "staking|cold_staking|cold_staking_v2"},
                        {"name": "transfer", "value": "transfer|spend"},
                    ]
                },
                {
                    "field": "wOrXNav",
                    "name": "Includes",
                    "primary": false,
                    "filters": [
                        {"name": "all", "value": "All", active: true, default: true},
                        {"name": "nav", "value": "Nav"},
                        {"name": "wNav", "value": "wNav"},
                        {"name": "xNav", "value": "xNav"},
                    ]
                }],
            true
        );
    }

    getRowData(data) {
        let amount;
        if (data.type === "staking") {
            amount = NumberFormat.format(data.stake/100000000);
        } else {
            let total = data.vout.reduce(function(prev, cur) {
                return prev + cur.value;
            }, 0);
            amount = NumberFormat.format(total)
        }
        if (data.type === "spend") data.type="transfer";

        return {
            type: data.type,
            hash: data.hash,
            hash_small: data.hash.substring(0, 12) + '...'+ data.hash.slice(-4),
            link: "/tx/"+data.hash,
            age: moment(data.time).utc().fromNow(),
            time: moment(data.time).utc().format('YYYY-MM-DD HH:mm:ss'),
            height: NumberFormat.format(data.height, false),
            confirmations: NumberFormat.format(data.confirmations ? data.confirmations : 0, false),
            amount: amount,
            fees: NumberFormat.format(data.fees/100000000, true, 4),
        }
    }
}

$(function() {
    if ($('body').is('.page-transaction-index')) {
        new TransactionIndexPage();
    }
});
