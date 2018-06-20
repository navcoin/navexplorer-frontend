const $ = require('jquery');


import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';

class PageTransaction {
    constructor() {
        console.log("Transaction Index Page");

        this.tableManager = new TableManager('#transaction-list table', 'transactions', this.createTableRow);
    }

    createTableRow(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/' + data.hash + '" class="break-word">' + data.hash.substring(20) + '...</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'height')
            .append('<a href="/block/'+ data.height + '">'+ data.height + '</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('MMM[&nbsp;]Do[&nbsp;]YYYY, h:mm:ss[&nbsp;]a'))
        );

        if (data.stake) {
            $row.append($(document.createElement('td'))
                .addClass("text-right")
                .attr('data-role', 'amount')
                .append('<span class="badge badge-info badge-staking">Staking</span>')
                .append(numberFormatter.format(data.stake) + '&nbsp;NAV')
            );
        } else {
            let amount = 0;
            data.outputs.forEach(function (output) {
                amount += output.amount;
            });
            $row.append($(document.createElement('td'))
                .addClass("text-right")
                .attr('data-role', 'amount')
                .append(numberFormatter.format(amount) + '&nbsp;NAV')
            );
        }

        return $row;
    }
}

$(function() {
    if ($('body').is('.page-transaction-index')) {
        new PageTransaction();
    }
});
