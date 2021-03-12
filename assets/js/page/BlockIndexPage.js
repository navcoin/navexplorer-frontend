const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import * as moment from 'moment';

class BlockIndexPage {
    constructor() {
        console.log("Block Index Page");

        this.tableManager = new TableManager('#block-list table', 'blocks', this.createTableRow);
    }

    createTableRow(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/block/'+data.height+'">' + data.hash.substring(0, 12) + '...'+data.hash.slice(-4)+'</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'height')
            .append(numberFormatter.format(data.height))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.created).utc().format('YYYY-MM-DD[,] HH:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'transactions')
            .addClass('text-center')
            .append(data.transactions)
        );

        let stakedBy = 'N/A';
        if (data.stakedBy) {
            stakedBy = '<a href="/address/' + data.stakedBy + '" class="break-word">' + data.stakedBy + '</a>';
        } else if (data.stake !== 0) {
            stakedBy = 'Private Address';
        }

        $row.append($(document.createElement('td'))
            .attr('data-role', 'stakedBy')
            .append(stakedBy)
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'stake')
            .addClass("text-right")
            .append(numberFormatter.formatNav(data.stake))
        );

        return $row;
    }
}


$(function() {
    if ($('body').is('.page-block-index')) {
        new BlockIndexPage();
    }
});