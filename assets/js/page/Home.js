import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';
import axios from "axios";

const $ = require('jquery');

class PageHome {
    constructor()
    {
        console.log("Home Page");
        this.tableManager = new TableManager('#blocks table', 'block', this.populateBlocks);
        this.tableManager = new TableManager('#txs table', 'transaction', this.populateTxs);

        this.populateTicker();
    }

    populateTicker() {
        let numberFormatter = new NavNumberFormat();

        axios.get("/ticker.json").then((response) => {
            $('#ticker-btc').html(response.data.btc.toFixed(8) + '&nbsp;BTC');
            $('#ticker-usd').html('$&nbsp;'+response.data.usd.toFixed(6));
            $('#market-cap').html('$&nbsp;'+numberFormatter.format(response.data.marketCap));
            $('#circulating-supply').html(numberFormatter.formatNav(response.data.circulatingSupply, false));
        });
    }

    populateBlocks(data, paginator) {
        let numberFormatter = new NavNumberFormat();

        if (typeof paginator !== "undefined") {
            $('#total-blocks').html(numberFormatter.format(paginator.total));
        }

        let $row = $(document.createElement('tr'));

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/block/'+data.height+'">' + data.hash.substring(0, 12) + '...'+data.hash.slice(-4)+'</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'height')
            .append('<a href="/block/'+data.height+'">' + numberFormatter.format(data.height) + '</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.created).utc().format('YYYY-MM-DD[,] HH:mm:ss'))
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'transactions')
            .attr('class', 'text-center')
            .append(data.transactions)
        );

        return $row;
    }

    populateTxs(data) {
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));

        $row.append($(document.createElement('td'))
            .attr('data-role', 'hash')
            .append('<a href="/tx/'+data.hash+'">' + data.hash.substring(0, 12) + '...'+data.hash.slice(-4)+'</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'height')
            .append('<a href="/block/'+data.height+'">' + numberFormatter.format(data.height) + '</a>')
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD[,] HH:mm:ss'))
        );

        let value = 0;
        data.outputs.forEach(function(output) { value += output.amount });
        $row.append($(document.createElement('td'))
            .attr('data-role', 'value out')
            .attr('class', 'text-right')
            .append(numberFormatter.format(value) + '&nbsp;Nav')
        );

        return $row;
    }
}

if ($('body').is('.page-home-index')) {
    new PageHome();
}