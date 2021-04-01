const $ = require('jquery');

import axios from "axios";

export default class TransactionLoader {
    loadBlockTransactions() {
        let self = this;
        let height = $('.block').data('height');

        axios.get('/block/'+height+'/tx.json').then(function (response) {
            self.transactionHtml(response.data);
        });
    }

    loadAddressTransactions(callback) {
        let address = $('.address').data('hash');

        axios.get('/address/'+address+'/tx').then(callback);
    }

    transactionHtml(data) {
        let self = this;
        let $transactionList = $(".transaction-list");
        data.forEach(function (tx) {
            $transactionList.append(
                '<div class="card card-nav">\n' +
                '  <div class="card-header">' +
                '    <h2 class="break-word"><a href="/tx/' + tx.hash+'" class="text-left">' + tx.hash + '</a></h2>\n' +
                '  </div>\n' +
                '  <div class="card-body">\n' +
                '    <div class="row">\n' +
                '      <div class="col-sm-12 col-md-6 inputs"><span class="caption">Inputs</span>' + self.inputList(tx.inputs, tx) + '</div>\n' +
                '      <div class="col-sm-12 col-md-6 outputs"><span class="caption">Vouts</span>' + self.inputList(tx.outputs, tx) + '</div>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</div>'
            );
        });
    }

    inputList(inputs, tx) {
        let BreakException = {};
        let list = $(document.createElement('ul'));
        let self = this;

        if (inputs) {
            try {
                inputs.forEach(function (input, index) {
                    let address = $(document.createElement('div'));
                    address.attr('class', 'address float-left');
                    if (typeof input.type !== 'undefined' && input.type === 'COLD_STAKING') {
                        address.append('<span class="break-word">' +
                            '  <a href="/address/' + input.addresses[0] + '">' + input.addresses[0] + '</a>' +
                            '</span>' +
                            '<span class="break-word">' +
                            '  <a href="/address/' + input.addresses[1] + '">' + input.addresses[1] + '</a>' +
                            '</span>');
                    } else if (typeof input.type !== 'undefined' && input.type === 'COLD_STAKING_V2') {
                        address.append('<span class="break-word">' +
                            '  <a href="/address/' + input.addresses[0] + '">' + input.addresses[0] + '</a>' +
                            '</span>' +
                            '<span class="break-word">' +
                            '  <a href="/address/' + input.addresses[1] + '">' + input.addresses[1] + '</a>' +
                            '</span>' +
                            '<span class="break-word">' +
                            '  <a href="/address/' + input.addresses[2] + '">' + input.addresses[2] + '</a>' +
                            '</span>');
                    } else if (input.private === true) {
                        address.html('Hidden');
                    } else if (typeof input.wrapped_addresses !== 'undefined' && input.wrapped_addresses.length !== 0) {
                        input.wrapped_addresses.forEach(element => address.append(element+'<br/>'));
                    } else if (typeof input.addresses !== 'undefined') {
                        if (input.addresses.length === 0) {
                            address.html('n/a');
                        } else {
                            let a = $(document.createElement('a')).attr('href', '/address/' + input.addresses[0]).html(input.addresses[0]);
                            address.append(a);
                        }
                    } else if (typeof input.address !== 'undefined') {
                        let a = $(document.createElement('a')).attr('href', '/address/' + input.address).html(input.address);
                        address.append(a);
                    } else {
                        address.html('n/a');
                    }

                    let amount = input.amount ? self.numberWithCommas(input.amount) : '0';
                    if (input.wrapped) {
                        amount += "&nbsp;wNav"
                    } else if (input.private) {
                        amount += "&nbsp;xNav"
                    } else {
                        amount += "&nbsp;Nav"
                    }
                    let amountDiv = $(document.createElement('div'));
                    amountDiv.attr('class', 'amount float-right');
                    amountDiv.html(amount);

                    let item = $(document.createElement('li'));
                    item.append(address);
                    item.append(amountDiv);

                    list.append(item);
                });
            } catch (e) {
                if (e === BreakException) {
                    let item = $(document.createElement('li')).append('<em>'+(inputs.length-5)+' more inputs...</em>');
                    list.append(item);
                } else {
                    throw e;
                }
            }
        } else {
            if (tx.type === "COINBASE") {
                return "Coinbase";
            }
        }

        return list[0].outerHTML;
    }

    numberWithCommas(x) {
        let parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if (typeof parts[1] !== 'undefined') {
            parts[1] = '<small>'+parts[1]+'</small>';
        }

        return parts.join(".");
    }

    sumOutputs(outputs) {
        let sum = 0;

        if (outputs) {
            outputs.forEach(function (output) {
                sum += output.amount;
            });
        }

        return '<span class="float-right"><strong>' + this.numberWithCommas(sum) + ' NAV' + '</strong></span>';
    }
}