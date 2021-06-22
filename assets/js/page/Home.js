import NumberFormat from "../services/NumberFormat";
import * as moment from 'moment';
import axios from "axios";
import Chart from "chart.js";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import nunjucks from "../services/Nunjucks";
import ExplorerApi from "../services/ExplorerApi";

const $ = require('jquery');

class PageHome {
    constructor() {
        console.log("Home Page");

        this.getLatestBlocks()
            .getLatestTxs()

        this.populateCirculation();
        // this.populateAddressGroups();

        this.populateTicker();
        this.populateMarketChart();
        this.populateCfund();
    }

    getLatestBlocks() {
        ExplorerApi.get("/block", {
            sort: [{ height: "desc" }],
            size: 5,
            page: 1,
        }, function(data) {
            data.elements.forEach(function(element) {
                element.short_hash = element.hash.substring(0, 20) + '...' + element.hash.slice(-4)
                element.height = NumberFormat.format(element.height, false)
                element.age = moment(element.time).utc().fromNow()
                element.time = moment(data.time).utc().format('YYYY-MM-DD HH:mm:ss');
            })
            nunjucks.render("home/latest-blocks.html", {blocks: data.elements, total: data.pagination.total}, function(err, html) {
                $('#blocks').html(html)
            }.bind(this))
        }.bind(this))

        return this
    }

    getLatestTxs() {
        let options = {sort: [{ txheight: "desc" }], size: 5, page: 1, filters: []}
        options.filters["type"] = "transfer|spend"

        ExplorerApi.get("/tx", options, function(data) {
            data.elements.forEach(function(element) {
                element.short_hash = element.hash.substring(0, 20) + '...' + element.hash.slice(-4)
                element.age = moment(element.time).utc().fromNow()
                element.time = moment(data.time).utc().format('YYYY-MM-DD HH:mm:ss');
                element.height_formatted = NumberFormat.format(element.height, false)
                let value = 0;
                element.vout.forEach(function(output) { value += output.valuesat });
                element.value = NumberFormat.formatSatNav(value, true, false)
            })
            nunjucks.render("home/latest-txs.html", {txs: data.elements, total: data.pagination.total}, function(err, html) {
                $('#txs').html(html)
            }.bind(this))
        }.bind(this))

        return this
    }

    populateCirculation() {
        console.info("populateCirculation")
        axios.get('/supply.json?blocks=1').then(this.loadCirculationData.bind(this));
    }

    loadCirculationData(response) {
        let elements = response.data;

        var chart = am4core.create("circulation-chart", am4charts.PieChart);
        chart.data = [
            { type: "Public", value: Math.round(elements[0].balance.public/100000000) },
            { type: "Private", value: Math.round(elements[0].balance.private/100000000) },
            { type: "Wrapped", value: Math.round(elements[0].balance.wrapped/100000000) },
        ];
        chart.radius = am4core.percent(95);
        chart.innerRadius = am4core.percent(65);
        chart.startAngle = 180;
        chart.endAngle = 360;

        var series = chart.series.push(new am4charts.PieSeries());
        series.dataFields.value = "value";
        series.dataFields.category = "type";

        series.slices.template.cornerRadius = 0;
        series.slices.template.innerCornerRadius = 0;
        series.slices.template.draggable = false;
        series.slices.template.inert = false;
        series.labels.template.disabled = true;
        series.ticks.template.disabled = true;

        series.hiddenState.properties.startAngle = 90;
        series.hiddenState.properties.endAngle = 90;

        chart.legend = new am4charts.Legend();
        chart.legend.valueLabels.template.disabled = true;
        chart.legend.paddingBottom = 20;
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
        let elements = response.data.reverse();

        let start = []
        let spend = []

        Array.min = function(array) {
            return Math.min.apply(Math, array);
        };

        Array.max = function(array) {
            return Math.max.apply(Math, array);
        };

        for (let i = 0; i < elements.length; i++) {
            start[i] = moment(elements[i].start).utc().format('YYYY-MM-DD');
            spend[i] = elements[i].spend;
        }
        let ctx = document.getElementById("address-groups-chart");

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
                    id: 'B',
                    type: 'linear',
                    position: 'left',
                    offset: false,
                    gridLines: {
                        display: true,
                    }
                }]
            },
            tooltips: {enabled: true},
            hover: {mode: null},
        };

        let data = {
            labels: start,
            datasets: [{
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
            }]
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
        axios.get("/ticker.json").then((response) => {
            $('#ticker-btc').html(response.data.btc.toFixed(8) + '&nbsp;BTC');
            $('#ticker-usd').html('$&nbsp;'+response.data.usd.toFixed(6));
            $('#market-cap').html('$&nbsp;'+NumberFormat.format(response.data.marketCap));
            $('#market-cap-rank').html('(#'+NumberFormat.format(response.data.marketCapRank)+')');
            $('#public-supply').html(NumberFormat.format(response.data.publicSupply, false) + ' Nav');
            $('#private-supply').html(NumberFormat.format(response.data.privateSupply, false) + ' xNav');
            $('#wrapped-supply').html(NumberFormat.format(response.data.wrappedSupply, false) + ' wNav');
        });
    }

    populateCfund() {

        axios.get("/community-fund/stats.json").then((response) => {
            $('#cfund-available').html(NumberFormat.format(response.data.available, false) + '&nbsp;Nav');
            $('#cfund-locked').html(NumberFormat.format(response.data.locked, false) + '&nbsp;Nav');
            $('#cfund-spent').html(NumberFormat.format(response.data.paid, false) + '&nbsp;Nav');
        });
    }
}

if ($('body').is('.page-home-index')) {
    new PageHome();
}