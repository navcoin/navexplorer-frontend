const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';
import Cookies from 'js-cookie'

class AddressIndexPage {

    constructor() {
        this.hash = $('.address').data('hash');

        new TableManager('#history-list table', 'historys', this.createHistoryRow);

        this.viewSpendingObj = $('<style>.view-spending { display: none; }</style>')
        this.viewStakingObj = $('<style>.view-staking { display: none; }</style>')
        this.viewVotingObj = $('<style>.view-voting { display: none; }</style>')

        this.initTableView()

    }

    initTableView() {
        if (!$('.form-address-type').length) {
            return
        }

        if (Cookies.get('v-sp') === undefined) { Cookies.set('v-sp', true) }
        if (Cookies.get('v-st') === undefined) { Cookies.set('v-st', true) }
        if (Cookies.get('v-vo') === undefined) { Cookies.set('v-vo', false) }
        this.updateTableView()

        let that = this
        $('.toggle-view-spending').each(function(index, element) {$(element).change(function() {
            console.log("click .toggle-view-spending")
        })});
        $('.toggle-view-spending').change(function() {
            // console.log("click .toggle-view-spending")
            $('.toggle-view-spending').each(function(index, element) {
                $(element).prop('checked', $(this).prop('checked'))
            })
            Cookies.set('v-sp', $(this).prop('checked'))
            that.updateTableView()
        })
        $('.toggle-view-staking').change(function() {
            console.log("click .toggle-view-staking")
            $('.toggle-view-staking').each(function(index, element) {
                $(element).prop('checked', $(this).prop('checked'))
            })
            Cookies.set('v-st', $(this).prop('checked'))
            that.updateTableView()
        })
        $('.toggle-view-voting').change(function() {
            console.log("click .toggle-view-voting")
            $('.toggle-view-voting').each(function(index, element) {
                $(element).prop('checked', $(this).prop('checked'))
            })
            Cookies.set('v-vo', $(this).prop('checked'))
            that.updateTableView()
        })
    }

    updateTableView() {
        if (Cookies.get('v-sp') === 'false' && Cookies.get('v-st') === 'false' && Cookies.get('v-vo') === 'false') {
            Cookies.set('v-sp', true)
            Cookies.set('v-st', true)
            Cookies.set('v-vo', true)
        }
        Cookies.get('v-sp') === 'false' ? this.viewSpendingObj.appendTo('head') : this.viewSpendingObj.detach()
        Cookies.get('v-st') === 'false' ? this.viewStakingObj.appendTo('head') : this.viewStakingObj.detach()
        Cookies.get('v-vo') === 'false' ? this.viewVotingObj.appendTo('head') : this.viewVotingObj.detach()

        $('.toggle-view-spending').each(function(index, element) {
            $(element).prop('checked', Cookies.get('v-sp') !== 'false')
        })

        $('.toggle-view-staking').each(function(index, element) {
            $(element).prop('checked', Cookies.get('v-st') !== 'false')
        })

        $('.toggle-view-voting').each(function(index, element) {
            $(element).prop('checked', Cookies.get('v-vo') !== 'false')
        })
    }

    createHistoryRow(data) {
        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.tx_id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD[<br/>@ ]HH:mm:ss'))
        );

        let type = $(document.createElement('td'))
            .attr('data-role', 'type')
        if (data.stake === true) {
            type.append('<span class="badge badge-info">Stake</span>')
        } else if (data.cfund_payout === true) {
            type.append('<span class="badge badge-success">Cfund Payout</span>');
        } else if (data.stake_payout === true) {
            type.append('<span class="badge badge-success">Stake Payout</span>');
        } else if (data.changes.spending < 0) {
            type.append('<span class="badge badge-warning">Send</span>')
        } else if (data.changes.spending > 0 || data.changes.staking > 0 || data.changes.voting > 0) {
            type.append('<span class="badge badge-success">Receive</span>')
        }
        $row.append(type)

        $row.append($(document.createElement('td'))
            .attr('data-role', 'txid')
            .append('<a href="/tx/'+data.tx_id+'" class="break-word d-none d-lg-inline">' + data.tx_id + '</a>')
            .append('<a href="/tx/'+data.tx_id+'" class="break-word d-sm-none d-md-inline d-lg-none">' + data.tx_id.substr(0, 30) + '...</a>')
            .append('<a href="/tx/'+data.tx_id+'" class="d-none d-sm-inline d-md-none">' + data.tx_id.substr(0, 15) + '...</a>')
            .append('<br/><small>Block:</small> <a href="/block/'+data.height+'">'+data.height+'</a></small>')
        );

        let changesLabel = $(document.createElement('td'))
        changesLabel.attr('class', 'hide')
        changesLabel.append($(document.createElement('div')).append('<strong>Changes</strong>'));
        changesLabel.append($(document.createElement('div')).append('<strong>Balance</strong>'));
        $row.append(changesLabel)

        let spendableRow = $(document.createElement('td')).attr('class', 'view-spending')
        spendableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'spending')).append('&nbsp;Nav'));
        spendableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'spending')).append('&nbsp;Nav'));
        $row.append(spendableRow)

        let stakableRow = $(document.createElement('td')).attr('class', 'view-staking')
        stakableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'staking')).append('&nbsp;Nav'));
        stakableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'staking')).append('&nbsp;Nav'));
        $row.append(stakableRow)

        let votingRow = $(document.createElement('td')).attr('class', 'view-voting')
        votingRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'voting')).append('&nbsp;Nav'));
        votingRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'voting')).append('&nbsp;Nav'));
        $row.append(votingRow)

        return $row;
    }

    static addChanges(changes, value) {
        let change = $(document.createElement('span'))

        if (changes[value] === 0) {
            change.attr('class', 'zero')
        }
        change.append(new NavNumberFormat().format(changes[value]))

        return change
    }
}


$(function() {
    if ($('body').is('.page-address-index')) {
        new AddressIndexPage();
    }
});