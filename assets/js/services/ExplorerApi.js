const $ = require('jquery');

import axios from "axios";

class ExplorerApi {
    constructor() {
        this.url = process.env['EXPLORER_API'];
    }

    get(path, options, callback) {
        console.info(path, options)
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
            if (values == null) {
                continue;
            }

            switch(option) {
                case "sort":
                    if (values.length > 0) {
                        query += "sort=";
                        values.forEach((v) => {
                            query += Object.keys(v)[0] + ":" + v[Object.keys(v)[0]] + ",";
                        });
                    }
                    break;
                case "filters":
                    if (Object.entries(values).length > 0) {
                        query += "filters=";
                        for (const [k, v] of Object.entries(values)) {
                            query += k+':'+v+","
                        }
                    }
                    break;
                case "size":
                case "page":
                    query += option + "=" + values + ",";
                    break;
            }

            query = query.replace(/(,$)/g, "&")
        }

        return query.replace(/(&$)/g, "")
    }

    _handleResponse(response, callback) {
        callback({
            "network": response.headers['x-network'],
            "elements": response.data,
            "pagination": response.headers['x-pagination'] ? JSON.parse(response.headers['x-pagination']) : null,
            "status": response.status,
        })
    }
}

export default new ExplorerApi()