const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';

class AddressIndexPage {
    constructor() {
        console.log("Page: Address Index");

        this.tableManager = new TableManager('#transaction-list table', 'transactions', this.createTableRow);
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
            .append(moment(data.time).utc().format('MMM[&nbsp;]Do[&nbsp;]YYYY, h:mm:ss[&nbsp;]a'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/'+data.transaction+'">' + data.transaction.substr(0, 15) + '...</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'amount')
            .append(numberFormatter.format(data.amount) + '&nbsp;NAV')
            .append(data.type === "STAKING" ? '&nbsp;<span class="badge badge-info">Stake</span>' : '')
        );

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