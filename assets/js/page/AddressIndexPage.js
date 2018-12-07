const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';

class AddressIndexPage {
    constructor() {
        console.log("Page: Address Index");

        this.tableManager = new TableManager('#transaction-list table', 'transactions', this.createTableRow);
        this.hash = $('.address').data('hash');
        console.log(this.hash);
    }

    createTableRow(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'block')
            .append('<a href="/block/'+data.height+'">'+data.height+'</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD[,] H:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/'+data.transaction+'">' + data.transaction.substr(0, 15) + '...</a>')
        );

        let $amountTd = $(document.createElement('td')).attr('data-role', 'amount')
            .append(numberFormatter.format(data.amount) + '&nbsp;NAV');
        if (data.type === "STAKING") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Stake</span>');
        } else if (data.type === "COLD_STAKING") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Cold Stake</span>');
        } else if (data.type === "COMMUNITY_FUND_PAYOUT") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Community Fund Payout</span>');
        }

        $row.append($amountTd);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'balance')
            .addClass("text-right")
            .append(numberFormatter.format(data.balance) + '&nbsp;NAV')
        );

        return $row;
    }
}


$(function() {
    if ($('body').is('.page-address-index')) {
        new AddressIndexPage();
    }
});