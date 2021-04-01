import nunjucks from "./Nunjucks";
import ExplorerApi from "./ExplorerApi";
import NumberFormat from "../services/NumberFormat";

const $ = require('jquery')

class Table {
    constructor(selector, api_path, dataProcessor, rowTemplate, options, filters, pagination) {
        this.selector = selector
        this.api_path = api_path
        this.dataProcessor = dataProcessor
        this.rowTemplate = rowTemplate
        this.options = options
        this.filters = filters
        this.pagination = pagination
    }

    init() {
        this.initFilters()
            .initPagination()
            .initTotal()

    }

    initFilters() {
        let table = this
        table.selector.on("click", ".table-filter", function (event) {
            event.preventDefault()
            table.handleChangeFilters({"field": $(event.target).data('field'), "name": $(event.target).html()})
        })

        return this
    }

    initPagination() {
        let table = this
        table.selector.on("click", ".table-pagination a", function (event) {
            event.preventDefault()
            table.handleChangePagination({"page": $(event.target).data('page')})
        })

        return this
    }

    initTotal() {
        this.selector.find('.table-total').addClass("d-none")

        return this
    }

    handleChangeFilters(data) {
        this.filters.forEach(function(item) {
            if (item.field === data.field) {
                item.filters.forEach(function(filter) {
                    filter.active = filter.name === data.name
                })
            }
        })
        this.pagination.current_page = 1

        this.request()
    }

    handleChangePagination(data) {
        this.pagination.current_page = data.page

        this.request()
    }

    request() {
        let options = this.options
        options.filters = []

        this.filters.forEach(function(item) {
            item.filters.forEach(function(filter) {
                if (filter.active === true) {
                    options.filters[item.field] = filter.value
                }
            })
        });

        options.page = this.pagination.current_page

        ExplorerApi.get(this.api_path, this.options, this.render.bind(this))
    }

    render(data) {
        let rowData = []
        data.elements.forEach(function(item) {
            rowData.push(this.dataProcessor(item))
        }.bind(this), this)

        nunjucks.render(this.rowTemplate, {data: rowData}, function(err, data) {
            this.updateTable(data)
        }.bind(this))

        this.renderFilters()
            .renderPagination(data.pagination)
            .renderTotal(data.pagination)
    }

    renderFilters() {
        this.selector.find('.table-filters').html("")

        nunjucks.render("table/filters.html", {data: this.filters}, function(err, html) {
            $(this.selector).find('.table-filters').html(html)
        }.bind(this))

        return this
    }

    renderPagination(pagination) {
        console.info("Table::renderPagination")
        this.pagination = pagination
        this.selector.find('.table-pagination').html("");

        nunjucks.render("table/pagination.html", {data: pagination}, function(err, html) {
            $(this.selector).find('.table-pagination').html(html);
        }.bind(this));

        return this
    }

    renderTotal(pagination) {
        this.selector.find('.table-total').html(NumberFormat.format(pagination.total, false) + " Total").removeClass("d-none")

        return this
    }

    updateTable(data) {
        this.emptyTable()
        this.selector.find('tbody').append(data);
    }

    emptyTable() {
        this.selector.find('thead').removeClass("loading");
        this.selector.find('tbody').empty();
    }
}

export default function CreateTable(selector, api_path, dataProcessor, rowTemplate, options, filters, pagination) {
    let table = new Table(selector, api_path, dataProcessor, rowTemplate, options, filters, pagination)

    table.init()
    table.request()

    return table
}