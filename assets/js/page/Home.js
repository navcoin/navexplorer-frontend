import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';
import axios from "axios";
import Chart from "chart.js";
import Distribution from "../services/Distribution";

const $ = require('jquery');

class PageHome {
    constructor()
    {
        console.log("Home Page");

        this.populateAddressGroups();

        this.populateTicker();
        this.populateMarketChart();

        this.tableManager = new TableManager('#blocks table', 'block', this.populateBlocks);
        this.tableManager = new TableManager('#txs table', 'transaction', this.populateTxs);
    }

    populateAddressGroups() {
        console.info("populateAddressGroups")
        let addressGroups = $('#address-groups');
        if (addressGroups.length) {
            let period = addressGroups.attr("data-period")
            let days = addressGroups.attr("data-days")
            axios.get('/address/group/' + period + '/' + days + '.json').then(this.loadAddressGroupData.bind(this));
        }
    }

    loadAddressGroupData(response) {
        let elements = response.data.elements.reverse();

        let start = []
        let end = []
        let addresses = []
        let stake = []
        let spend = []

        Array.min = function(array) {
            return Math.min.apply(Math, array);
        };

        Array.max = function(array) {
            return Math.max.apply(Math, array);
        };

        for (let i = 0; i < elements.length; i++) {
            start[i] = moment(elements[i].start).utc().format('YYYY-MM-DD');
            end[i] = elements[i].end;
            addresses[i] = elements[i].addresses;
            stake[i] = elements[i].stake;
            spend[i] = elements[i].spend;
        }
        let ctx = document.getElementById("address-groups-chart");

        let minAddresses = Math.ceil(Array.min(addresses) / 1.2);
        let minStaking = Math.ceil(Array.min(spend) / 1.2);
        let maxStaking = Math.ceil(Array.min(spend) * 1.2);

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [
                //     {
                //     id: 'A',
                //     type: 'linear',
                //     position: 'right',
                //     offset: false,
                //     gridLines: {
                //         display: true,
                //     // },
                //     // ticks: {
                //     //     min: minAddresses,
                //     // },
                //     // afterTickToLabelConversion: function(scaleInstance) {
                //     //     if (minAddresses !== 0) {
                //     //         scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                //     //         scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                //     //     }
                //     }
                // },
                {

                    id: 'B',
                    type: 'linear',
                    position: 'left',
                    offset: false,
                    gridLines: {
                        display: true,
                    },
                    afterTickToLabelConversion: function(scaleInstance) {
                        // if (minStaking !== 0) {
                        //     scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                        //     scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                        // }

                        // if (maxStaking != 0) {
                        //     scaleInstance.ticks[0] = null;
                        //     scaleInstance.ticksAsNumbers[0] = null;
                        // }
                    }
                }]
            },
            tooltips: {enabled: true},
            hover: {mode: null},
        };

        let data = {
            labels: start,
            datasets: [
                // {
                //     label: 'Staking Addresses',
                //     fill: true,
                //     lineTension: 0.4,
                //     backgroundColor: "rgba(0,0,0,0)",
                //     borderColor: "hsl(199, 81%, 59%)",
                //     borderWidth: 3,
                //     pointRadius: 2,
                //     pointBackgroundColor: "hsl(199, 81%, 59%)",
                //     data: stake,
                //     spanGaps: true,
                //     yAxisID: 'A',
                // },
                {
                    gridLines: {
                        display: true,
                    },
                    fill: true,
                    label: 'Active Addresses',
                    lineTension: 0.4,
                    backgroundColor: "rgba(0,0,0,0)",
                    borderColor: "rgb(183, 61, 175)",
                    borderWidth: 3,
                    pointRadius: 2,
                    pointBackgroundColor: "rgb(183, 61, 175)",
                    data: spend,
                    spanGaps: true,
                    yAxisID: 'B'
                },
            ]
        };

        let myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options,
        });
        myLineChart.canvas.parentNode.style.height = '300px';
    }

    populateMarketChart() {
        console.info("populateMarketChart")
        let marketChart = $('#market-chart');
        if (marketChart.length) {
            let currency = marketChart.attr("data-currency")
            let days = marketChart.attr("data-days")
            axios.get('/market/chart/' + currency + '/' + days + '.json').then(this.loadMarketChartData.bind(this));
        }
    }

    loadMarketChartData(response) {
        let elements = response.data;

        let date = []
        let usdPrice = []
        let btcPrice = []

        Array.min = function(array) {
            return Math.min.apply(Math, array);
        };

        Array.max = function(array) {
            return Math.max.apply(Math, array);
        };

        for (let i = 0; i < elements.length; i++) {
            let timestamp = String(elements[i]['time'].toString());
            date[i] = moment.unix(timestamp).utc().format('YYYY-MM-DD');
            usdPrice[i] = elements[i]['usd'].toFixed(4);
            btcPrice[i] = elements[i]['btc'];
        }
        let ctx = document.getElementById("market-chart-chart");

        // let minAddresses = Math.ceil(Array.min(addresses) / 1.2);
        // let minStaking = Math.ceil(Array.min(spend) / 1.2);
        // let maxStaking = Math.ceil(Array.min(spend) * 1.2);

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    id: 'A',
                    type: 'linear',
                    position: 'left',
                    offset: false,
                    gridLines: {
                        display: true,
                    }
                },{
                    id: 'B',
                    type: 'linear',
                    position: 'right',
                    offset: false,
                    gridLines: {
                        display: false,
                    }
                }],
            },
            tooltips: {enabled: true},
            hover: {mode: null},
        };

        let data = {
            labels: date,
            datasets: [
                {
                    label: 'Price (USD)',
                    fill: true,
                    lineTension: 0.4,
                    backgroundColor: "rgba(0,0,0,0)",
                    borderColor: "hsl(199, 81%, 59%)",
                    borderWidth: 3,
                    pointRadius: 2,
                    pointBackgroundColor: "hsl(199, 81%, 59%)",
                    data: usdPrice,
                    spanGaps: true,
                    yAxisID: 'A',
                },
                {
                    label: 'Price (BTC)',
                    fill: true,
                    lineTension: 0.4,
                    backgroundColor: "rgba(0,0,0,0)",
                    borderColor: "rgb(183, 61, 175)",
                    borderWidth: 3,
                    pointRadius: 2,
                    pointBackgroundColor: "rgb(183, 61, 175)",
                    data: btcPrice,
                    spanGaps: true,
                    yAxisID: 'B',
                }
            ]
        };

        let myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options,
        });
        myLineChart.canvas.parentNode.style.height = '300px';
    }

    populateTicker() {
        let numberFormatter = new NavNumberFormat();

        axios.get("/ticker.json").then((response) => {
            $('#ticker-btc').html(response.data.btc.toFixed(8) + '&nbsp;BTC');
            $('#ticker-usd').html('$&nbsp;'+response.data.usd.toFixed(6));
            $('#market-cap').html('$&nbsp;'+numberFormatter.format(response.data.marketCap));
            $('#circulating-supply  ').html(numberFormatter.formatNav(response.data.circulatingSupply, false));
            $('#public-supply').html(numberFormatter.formatNav(response.data.publicSupply, false));
            $('#private-supply').html(numberFormatter.formatNav(response.data.privateSupply, false, true));
        });
    }

    populateBlocks(data, paginator) {
        let numberFormatter = new NavNumberFormat();

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

        $row.append($(document.createElement('td'))
            .attr('data-role', 'stakedBy')
            .attr('class', 'text-right')
            .append('<a href="/address/'+data.staked_by+'">' + data.staked_by.substring(0, 12) + '...'+data.staked_by.slice(-4)+'</a>')
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

        $row.append($(document.createElement('td'))
            .attr('data-role', 'inputs')
            .attr('class', 'text-center')
            .append(data.inputs.length)
        );

        $row.append($(document.createElement('td'))
            .attr('data-role', 'outputs')
            .attr('class', 'text-center')
            .append(data.outputs.length)
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