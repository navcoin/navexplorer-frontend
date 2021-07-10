import CreateTable from "../services/Table";
import Distribution from "../services/Distribution";
import NumberFormat from "../services/NumberFormat";

const $ = require('jquery');


class AddressesPage {
    constructor() {
        console.log("Addresses Index Page");

        this.addressesList()

        new Distribution('#wealthDistribution', '/distribution/balance.json');
    }

    addressesList() {
        this.table = CreateTable($("#addresses-list"),
            "/address",
            this.getRowData,
            'addresses/table-row.html',
            {
                size: 20,
                page: 1,
            },
            [
                {
                    "field": "exclude",
                    "name": "Exclude Empty",
                    "primary": true,
                    "filters": [
                        {"name": "Exclude Empty Addresses", "value": "empty", "active": true, default: true},
                        {"name": "Exclude Known Exchange Addresses", "value": "exchange", "active": false, default: false},
                    ]
                }
            ],
            [
                {"name": "Spendable", "value": "spendable:desc", "active": true, default: true},
                {"name": "Stakable", "value": "stakable:desc", "active": false, default: false},
                {"name": "Voting Weight", "value": "voting_weight:desc", "active": false, default: false},
            ],
            true
        );
    }

    getRowData(data) {
        if (data.meta && data.meta.label) {
            data.label = data.meta.label
        }
        data.spendable = NumberFormat.formatSatNav(data.spendable, 8, false, false)
        data.stakable = NumberFormat.formatSatNav(data.stakable, 8, false, false)
        data.voting_weight = NumberFormat.formatSatNav(data.voting_weight, 8, false, false)

        return data
    }
}


$(function() {
    if ($('body').is('.page-addresses-index')) {
        new AddressesPage();
    }
});