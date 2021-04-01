import CreateTable from "../services/Table";

const $ = require('jquery');

import NumberFormat from "../services/NumberFormat";
import * as moment from 'moment';

class AddressIndexPage {
    constructor() {
        this.hash = $('.address').data('hash');

        CreateTable($("#history-list"),
            "/address/"+this.hash+"/history",
            this.getRowData,
            'address/history-table-row.html',
            {
                sort: [
                    { height: "desc" }
                ],
                size: 20,
                page: 1,
            },
            [
                {
                    "field": "type",
                    "primary": true,
                    "filters": [
                        {"name": "All", "value": "", "active": true},
                        {"name": "Staking", "value": "staking"},
                        {"name": "Sending", "value": "sending"},
                        {"name": "Receiving", "value": "receiving"},
                    ]
                }],
            true
        );
    }

    getRowData(data) {
        if (data.is_stake) {
            data.type = "staking"
        } else if (data.is_cfund_payout) {
            data.type = "cfund payout"
        } else if (data.is_stake_payout === true) {
            data.type = "stake payout"
        } else if (data.changes.spendable < 0 || data.changes.stakable < 0 || data.changes.voting_weight < 0) {
            data.type = "sending"
        } else {
            data.type = "receiving"
        }

        data.age = moment(data.time).utc().fromNow()

        data.time = moment(data.time).utc().format('YYYY-MM-DD HH:mm:ss');

        data.changes.spendable = NumberFormat.formatSatNav(data.changes.spendable, true, false, true)
        data.changes.stakable = NumberFormat.formatSatNav(data.changes.stakable, true, false, true)
        data.changes.voting_weight = NumberFormat.formatSatNav(data.changes.voting_weight, true, false, true)
        data.balance.spendable = NumberFormat.formatSatNav(data.balance.spendable, true, false)
        data.balance.stakable = NumberFormat.formatSatNav(data.balance.stakable, true, false)
        data.balance.voting_weight = NumberFormat.formatSatNav(data.balance.voting_weight, true, false)

        return data
    }
}


$(function() {
    if ($('body').is('.page-address-index')) {
        new AddressIndexPage();
    }
});