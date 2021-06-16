const $ = require('jquery');

import axios from "axios";
import Pagination from "../services/Pagination";
import FormFilter from "../services/FormFilter";

export default class TableManager {
    constructor(identifier, elementType, rowCreatedCallback) {
        let table = $(identifier);
        this.elementType = elementType;
        this.rowCreatedCallback = rowCreatedCallback;

        if (table.length !== 1) {
            return;
        }

        this.init(table);
    }

    init(table) {
        this.table = table;
        this.dataUrl = this.table.attr('data-url');
        this.pagination = new Pagination(this);
        this.formFilter = new FormFilter();

        this.loadDefaultPage(this.dataUrl);
    }

    loadDefaultPage(dataUrl) {
        axios.get(dataUrl).then(this.handleDefaultResponse.bind(this));
    }

    loadNextPage(dataUrl) {
        axios.get(dataUrl).then(this.handleNextResponse.bind(this));
    }

    handleDefaultResponse(response) {
        if (typeof response.headers['x-pagination'] !== "undefined") {
            let paginationData = JSON.parse(response.headers['x-pagination']);
            this.pagination.init(paginationData);
            this.handleResponse(response.data, paginationData);

        } else if (typeof response.headers.paginator === "undefined") {
            if (this.paginated === true) {
                this.pagination.hide();
            }
            this.handleResponse(response.data);
        } else {
            this.pagination.init(JSON.parse(response.headers.paginator));
            this.handleResponse(response.data, JSON.parse(response.headers.paginator));
        }
    }

    handleNextResponse(response) {
        let elements = response.data;

        if (typeof elements === "undefined") {
            if (this.paginated === true) {
                this.pagination.hide();
            }
        } else {
            this.handleResponse(elements);
        }
    }

    handleResponse(data, paginator) {
        this.emptyTable();

        if (data.length === 0) {
            this.noResultsFound();
        }

        data.forEach(function (tx) {
            this.table.append(this.rowCreatedCallback(tx, paginator));
        }.bind(this));

        this.pagination.render();
    }

    noResultsFound() {
        let columnCount = this.table.find("thead tr:first th").length;

        this.table.append('<tr><th colspan="' + columnCount + '" class="text-center"><em>There are no ' + this.elementType + '</em></th></tr>');
    }

    emptyTable() {
        this.table.find('tbody').empty();
    }
}