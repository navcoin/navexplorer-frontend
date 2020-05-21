const $ = require('jquery');

import anchorme from "anchorme";
import Chart from 'chart.js';
import 'chartjs-plugin-annotation';
import axios from "axios";

class CommunityFundProposalViewPage {
    constructor()
    {
        console.log("CommunityFund Proposal View");

        this.autoLinkDescription();
        this.createTrendGraph();
    }

    autoLinkDescription() {
        let $proposalDescription = $('.proposal-description');
        $proposalDescription.html(
            anchorme($proposalDescription.html(), {
                attributes:[
                    {
                        name:"target",
                        value:"_blank"
                    }
                ]
            })
        );
    }

    createTrendGraph() {
        if ($('#votes').length) {
            axios.get('/community-fund/proposal/' + $("#proposal-hash").html() + '/trend.json').then(this.loadChartData.bind(this));
        }
    }

    loadChartData(response) {
        let elements = response.data.elements;

        let blocks = [];
        let yes = [];
        let no = [];
        let abstain = [];

        for (let i = 0; i < elements.length; i++) {
            blocks[i] = elements[i].end;
            yes[i] = elements[i].trend_yes;
            no[i] = elements[i].trend_no;
            abstain[i] = elements[i].trend_abstain;
        }

        let ctx = document.getElementById("trendChart");
        var options = {
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }
                }],
                yAxes: [{
                    stacked: true,
                }]
            },
            tooltips: {enabled: false},
            hover: {mode: null},
            annotation: {
                annotations: [
                    {
                        drawTime: "afterDatasetsDraw",
                        id: "hline",
                        type: "line",
                        mode: "horizontal",
                        scaleID: "y-axis-0",
                        value: 50,
                        borderColor: "rgb(220,220,220)",
                        borderWidth: 3
                    },
                ]
            }
        };

        let data = {
            labels: blocks,
            datasets: [
                {
                    fill: true,
                    lineTension: 0.4,
                    backgroundColor: "rgba(224, 224, 224, 1)",
                    borderColor: "rgba(232,232,232, 0)",
                    pointRadius: 0,
                    data: abstain,
                    spanGaps: false,
                    scaleOverride : true,
                    scaleSteps : 20,
                    scaleStepWidth : 50,
                    scaleStartValue : 0
                },
                {
                    fill: true,
                    lineTension: 0.4,
                    backgroundColor: "rgba(221,109,109,1)",
                    borderColor: "rgba(217,83,79,0)",
                    pointRadius: 0,
                    data: no,
                    spanGaps: false,
                    scaleOverride : true,
                    scaleSteps : 20,
                    scaleStepWidth : 50,
                    scaleStartValue : 0
                },
                {
                    fill: true,
                    lineTension: 0.4,
                    backgroundColor: "rgba(164,204,109,1)",
                    borderColor: "rgba(147,197,75,0)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointRadius: 0,
                    data: yes,
                    spanGaps: false,
                    scaleOverride : true,
                    scaleSteps : 20,
                    scaleStepWidth : 50,
                    scaleStartValue : 0
                },
            ]
        };

        let myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options,
        });
    }
}

if ($('body').is('.page-communityfund-proposal-view')) {
    new CommunityFundProposalViewPage();
}