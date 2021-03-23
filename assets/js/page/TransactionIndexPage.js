const $ = require('jquery');

import NavNumberFormat from "../services/NavNumberFormat";
import ExplorerApi from "../services/ExplorerApi";
import * as moment from 'moment';

class TransactionIndexPage {
    constructor() {
        this.table = $('#transaction-list table');

        this.numberFormatter = new NavNumberFormat();
        this.explorerApi = new ExplorerApi();
        this.explorerApi.getTransactions({
            sort: [
                {txheight: "desc"},
                {index: "asc"},
            ],
        }, this.handleData.bind(this))
    }

    handleData(data) {
        this.emptyTable()
        data.elements.forEach(this.createTableRow, this);
    }

    emptyTable() {
        this.table.find('tbody').empty();
    }

    createTableRow(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'type')
            .append(data.type)
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/' + data.hash + '" class="break-word">' + data.hash.substring(20) + '...</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD[,] H:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'height')
            .append('<a href="/block/'+ data.height + '">'+ data.height + '</a>')
        );

        if (data.type == "staking") {
            $row.append($(document.createElement('td'))
                .attr('data-role', 'amount')
                .append(numberFormatter.format(data.stake/100000000) + '&nbsp;Nav')
            );
        } else {
            let amount = 0;
            data.vout.forEach(function (output) {
                amount += output.valuesat;
            });
            $row.append($(document.createElement('td'))
                .attr('data-role', 'amount')
                .append(numberFormatter.format(amount) + '&nbsp;Nav')
            );
        }

        $row.append($(document.createElement('td'))
            .attr('data-role', 'fees')
            .append(numberFormatter.format(data.fees) + '&nbsp;Nav')
        );

        this.table.append($row)
    }
}

$(function() {
    if ($('body').is('.page-transaction-index')) {
        new TransactionIndexPage();
    }
});
