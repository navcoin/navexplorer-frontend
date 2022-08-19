import nunjucks from "./Nunjucks";
import ExplorerApi from "./ExplorerApi";
import NumberFormat from "../services/NumberFormat";

const $ = require('jquery')

class Table {
    constructor(selector, api_path, dataProcessor, rowTemplate, options, filters, sorts, pagination) {
        this.selector = selector
        this.api_path = api_path
        this.dataProcessor = dataProcessor
        this.rowTemplate = rowTemplate
        this.options = options
        this.filters = filters
        this.sorts = sorts
        this.pagination = pagination
    }

    init() {
        this.initFilters()
            .initSorts()
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

    initSorts() {
        let table = this
        table.selector.on("click", ".table-sort", function (event) {
            event.preventDefault()
            table.handleChangeSorts({"name": $(event.target).data('name')})
        })

        return this
    }

    getActiveSort() {
        let active = null;
        this.sorts.forEach(function(sort) {
            if (sort.active === true) {
                active = sort;
            }
        });

        return active;
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
        let that = this

        this.filters.forEach(function(item) {
            if (item.field === data.field) {
                if (item.filters.length === 1) {
                    item.filters[0].active = !item.filters[0].active
                } else {
                    item.filters.forEach(function (filter) {
                        if (filter.name === data.name && filter.active) {
                            that.resetFilter(item.filters)
                        } else {
                            filter.active = filter.name === data.name
                        }
                    })
                }
            }
        })
        this.pagination.current_page = 1

        this.request()
    }

    handleChangeSorts(data) {
        this.sorts.forEach(function(item) {
            item.active = item.name === data.name
        })
        this.pagination.current_page = 1

        this.request()
    }

    handleChangePagination(data) {
        this.pagination.current_page = data.page

        this.request()
    }

    resetFilter(item) {
        item.forEach(function(filter) {
            filter.active = filter.default === true
        })
    }

    request() {
        let options = this.options
        options.filters = []
        options.sorts = []

        this.filters.forEach(function(item) {
            item.filters.forEach(function(filter) {
                if (filter.active === true) {
                    options.filters[item.field] = filter.value
                }
            })
        });

        if (this.sorts) {
            this.sorts.forEach(function (sort) {
                if (sort.active === true) {
                    options.sort = sort.value
                }
            });
        }

        options.page = this.pagination.current_page

        this.selector.addClass('blink')
        ExplorerApi.get(this.api_path, this.options, this.render.bind(this))
    }

    render(data) {
        let rowData = []
        data.elements.forEach(function(item) {
            rowData.push(this.dataProcessor(item, this))
        }.bind(this), this)

        nunjucks.render(this.rowTemplate, {data: rowData}, function(err, data) {
            this.updateTable(data)
        }.bind(this))

        this.renderFilters()
            .renderSorts()
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

    renderSorts() {
        this.selector.find('.table-sorts').html("")

        nunjucks.render("table/sorts.html", {data: this.sorts}, function(err, html) {
            $(this.selector).find('.table-sorts').html(html)
        }.bind(this))

        return this
    }

    renderPagination(pagination) {
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
        this.selector.removeClass('blink')
        this.selector.find('.table-loader').hide()
    }

    emptyTable() {
        this.selector.find('thead').removeClass("loading");
        this.selector.find('tbody').empty();
    }
}

export default function CreateTable(selector, api_path, dataProcessor, rowTemplate, options, filters, sorts, pagination) {
    let table = new Table(selector, api_path, dataProcessor, rowTemplate, options, filters, sorts, pagination)

    table.init()
    table.request()

    return table
}
