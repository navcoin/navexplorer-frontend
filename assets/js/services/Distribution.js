const $ = require('jquery');

import axios from "axios";
import * as d3 from "d3";
import NavNumberFormat from "../services/NavNumberFormat";

export default class Distribution {
    constructor(target, dataUrl) {
        this.target = target;
        this.dataUrl = dataUrl;
        this.init();
    }

    init() {
        this.dataSet = [];
        axios.get(this.dataUrl).then(this.handleData.bind(this));
        this.colors = ['#4d3474', '#44B5E9', '#1547AE', '#CE2DAF', '#5A78D1', '#5879D2', '#1547AE', '#41BEEB'];
    }

    handleData(response) {
        if (response.status !== 200) {
            return;
        }

        if (typeof response.data === "undefined") {
            return;
        }

        this.buildChart(response.data);
        this.buildTable(response.data);
    }

    buildChart(segments) {
        let navNumberFormat = new NavNumberFormat();
        let excluded = 0
        segments.forEach(function (segment) {
            this.dataSet.push({
                'label': segment.group ? 'Top ' + segment.group + ' (' + segment.percentage + '%) - ' + navNumberFormat.formatNav(segment.balance, false) : 'All - ' + navNumberFormat.formatNav(segment.balance, false),
                'count': segment.balance - excluded,
            });
            excluded = segment.balance;
        }.bind(this));

        let width = 290;
        let height = 290;
        let radius = Math.min(width, height) / 2;

        let colors = d3.scaleOrdinal().range(this.colors);

        let svg = d3.select(this.target + " svg")
            .attr('width', width)
            .attr('height', height)
            .append('g')
            .attr('transform', 'translate(' + width/2 + ',' + height/2 +')');

        let arc = d3.arc()
            .innerRadius(radius - 75)
            .outerRadius(radius);

        let pie = d3.pie()
            .value(function(d) { return d.count; })
            .sort(null);

        let path = svg.selectAll('path')
            .data(pie(this.dataSet))
            .enter()
            .append('path')
            .attr('d', arc)
            .attr('fill', function(d, i) {
                return colors(d.data.label);
            });
    }

    buildTable(segments) {
        let numberFormatter = new NavNumberFormat();

        let $table = $(this.target + " table");
        let $tablebody = $table.find("tbody").empty();
        let colors = this.colors;

        segments.forEach(function(segment, index) {
            let $row = $(document.createElement('tr'));

            $row.append($(document.createElement('td'))
                .attr('class', 'text-center')
                .append('<span class="box" style="background-color:'+colors[index]+'"></span>')
            );

            $row.append($(document.createElement('td'))
                .append(segment.group ? numberFormatter.format(segment.group) : 'All')
            );

            $row.append($(document.createElement('td'))
                .append(numberFormatter.formatNav(segment.balance, false))
            );

            $row.append($(document.createElement('td'))
                .attr('class', 'text-center')
                .append(numberFormatter.format(segment.percentage, false) + '%')
            );
            $tablebody.append($row);
        });
    }
}