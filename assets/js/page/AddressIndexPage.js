const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';

class AddressIndexPage {
    constructor() {

        this.hash = $('.address').data('hash');

        this.tableManager = new TableManager('#transaction-list table', 'transactions', this.createTableRow);

        if ($('#cold-transaction-list').length !== 0) {
            this.tableManager = new TableManager('#cold-transaction-list table', 'transactions', this.createColdTableRow);
        }
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
            .append(moment(data.time).utc().format('YYYY-MM-DD[,] HH:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/'+data.transaction+'">' + data.transaction.substr(0, 15) + '...</a>')
        );

        let $amountTd = $(document.createElement('td')).attr('data-role', 'amount')
            .append(numberFormatter.format(data.total) + '&nbsp;NAV');
        if (data.type === "stake") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Stake</span>');
        } else if (data.type === "cold_stake") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Cold Stake</span>');
        } else if (data.type === "community_fund_payout") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Community Fund</span>');
        }

        $row.append($amountTd);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'balance')
            .addClass("text-right")
            .append(numberFormatter.format(data.balance) + '&nbsp;NAV')
        );

        return $row;
    }

    createColdTableRow(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'block')
            .append('<a href="/block/'+data.height+'">'+data.height+'</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD[,] HH:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/'+data.transaction+'">' + data.transaction.substr(0, 15) + '...</a>')
        );

        let $amountTd = $(document.createElement('td')).attr('data-role', 'amount')
            .append(numberFormatter.format(data.total) + '&nbsp;NAV');
        if (data.type === "cold_stake") {
            $amountTd.append('&nbsp;<span class="badge badge-info">Stake</span>');
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