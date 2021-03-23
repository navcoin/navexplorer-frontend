const $ = require('jquery');

import axios from "axios";

export default class ExplorerApi {
    constructor() {
        this.url = process.env['EXPLORER_API'];
    }

    getTransactions(options, callback) {
        this.options = options
        this._get("/tx", options, callback)
    }

    _get(path, options, callback) {
        axios.get(this.url + path + (options ? "?" + this._formatParams(options) : ''))
            .then(response => {
                this._handleResponse(response, callback)
            })
            .catch((error) => {
                console.log('Show error notification!')
                return Promise.reject(error)
            })
        ;
    }

    _formatParams(options) {
        let query = "";

        for (const [option, values] of Object.entries(options)) {
            query += option + "=";
            values.forEach((v) => {
                query += Object.keys(v)[0] + ":" + v[Object.keys(v)[0]] +",";
            });
            query = query.replace(/(,$)/g, "&")
        }

        return query.replace(/(&$)/g, "")
    }

    _handleResponse(response, callback) {
        callback({
            "network": response.headers['x-network'],
            "elements": response.data,
            "pagination": JSON.parse(response.headers['x-pagination']),
            "status": response.status,
            "options": this.options,
        })
    }
}