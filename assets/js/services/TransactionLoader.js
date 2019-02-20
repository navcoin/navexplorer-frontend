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
        data.elements.forEach(function (tx) {
            $transactionList.append(
                '<div class="card">\n' +
                '  <div class="card-header">\n' +
                '    <a href="/tx/' + tx.hash+'" class="text-left">' + tx.hash + '</a>' +
                self.sumOutputs(tx.outputs) +
                '  </div>\n' +
                '  <div class="card-body">\n' +
                '    <div class="row">\n' +
                '      <div class="col-sm-12 col-md-6 inputs"><span class="caption">Inputs</span>' + self.inputList(tx.inputs, tx) + '</div>\n' +
                '      <div class="col-sm-12 col-md-6 outputs"><span class="caption">Outputs</span>' + self.inputList(tx.outputs, tx) + '</div>\n' +
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
                    } else if (typeof input.type !== 'undefined' && input.type !== 'PUBKEY' && input.type !== 'PUBKEYHASH') {
                        address.html(input.type.toLowerCase());
                    } else if (typeof input.addresses !== 'undefined') {
                        if (input.addresses.length === 0) {
                            if (tx.type === "PRIVATE_STAKING") {
                                address.html('Private address');
                            } else {
                                address.html('N/A');
                            }
                        } else {
                            let a = $(document.createElement('a')).attr('href', '/address/' + input.addresses[0]).html(input.addresses[0]);
                            address.append(a);
                        }
                    } else if (typeof input.address !== 'undefined') {
                        let a = $(document.createElement('a')).attr('href', '/address/' + input.address).html(input.address);
                        address.append(a);
                    } else {
                        address.html('N/A');
                    }

                    let amount = $(document.createElement('div'));
                    amount.attr('class', 'amount float-right');
                    amount.html((input.amount ? self.numberWithCommas(input.amount) : '0') + ' NAV');

                    let item = $(document.createElement('li'));
                    item.append(address);
                    item.append(amount);

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