import CreateTable from "../services/Table";

const $ = require('jquery');

import NumberFormat from "../services/NumberFormat";
import * as moment from 'moment';

class AddressIndexPage {
    constructor() {
        this.hash = $('.address').data('hash');

        console.log("Create History list")
        CreateTable($("#history-list"),
            "/address/"+this.hash+"/history",
            this.getRowData,
            'address/history-table-row.html',
            {
                sort: "height:desc,txindex:desc",
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
                },
            ],
            [
                {"name": "default", "value": "height:desc,txindex:desc", "active": true, default: true},
            ],
            true
        );
    }

    getRowData(data) {

        console.log(data);

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

        data.changes.spendable = NumberFormat.formatSatNav(data.changes.spendable, 4, false, true)
        data.changes.stakable = NumberFormat.formatSatNav(data.changes.stakable, 4, false, true)
        data.changes.voting_weight = NumberFormat.formatSatNav(data.changes.voting_weight, 4, false, true)
        data.balance.spendable = NumberFormat.formatSatNav(data.balance.spendable, 4, false)
        data.balance.stakable = NumberFormat.formatSatNav(data.balance.stakable, 4, false)
        data.balance.voting_weight = NumberFormat.formatSatNav(data.balance.voting_weight, 4, false)

        return data
    }
}


$(function() {
    if ($('body').is('.page-address-index')) {
        new AddressIndexPage();
    }
});