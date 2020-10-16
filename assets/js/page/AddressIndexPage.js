const $ = require('jquery');

import TableManager from "../services/TableManager";
import NavNumberFormat from "../services/NavNumberFormat";
import moment from 'moment/src/moment';
import Cookies from 'js-cookie'

class AddressIndexPage {

    constructor() {
        this.hash = $('.address').data('hash');

        new TableManager('#history-list table', 'transactions', this.createHistoryRow);

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
        let numberFormatter = new NavNumberFormat();

        let $row = $(document.createElement('tr'));
        $row.attr('data-id', data.tx_id);

        $row.append($(document.createElement('td'))
            .attr('data-role', 'transaction')
            .append('<a href="/tx/'+data.tx_id+'" class="break-word d-none d-lg-inline">' + data.tx_id.substr(0, 15) + '...</a>')
            .append('<a href="/tx/'+data.tx_id+'" class="break-word d-sm-inline d-md-inline d-lg-none">' + data.tx_id.substr(0, 15) + '...</a>')
            .append('<div><small>Block:</small> <a href="/block/'+data.height+'">'+numberFormatter.format(data.height)+'</a></small></div>')
        );

        let type = $(document.createElement('td'))
            .attr('data-role', 'type')
        if (data.stake === true) {
            type.append('<span class="badge badge-info">Stake</span>')
        } else if (data.cfund_payout === true) {
            type.append('<span class="badge badge-success">Cfund Payout</span>');
        } else if (data.stake_payout === true) {
            type.append('<span class="badge badge-success">Stake Payout</span>');
        } else {
            type.append('<span class="badge badge-success">Spend</span>')
        }
        $row.append(type)

        $row.append($(document.createElement('td'))
            .attr('data-role', 'date/time')
            .append(moment(data.time).utc().format('YYYY-MM-DD'))
            .append('<br/>')
            .append(moment(data.time).utc().format('HH:mm:ss'))
        );

        let changesLabel = $(document.createElement('td'))
        changesLabel.attr('class', 'hide text-right')
        changesLabel.append($(document.createElement('div')).append('<label>Changes</label>'));
        changesLabel.append($(document.createElement('div')).append('<label>Balance</label>'));
        $row.append(changesLabel)

        let spendableRow = $(document.createElement('td')).attr('class', 'text-right hide').attr('data-role', 'spendable')
        spendableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'spending', true)).append('&nbsp;Nav'));
        spendableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'spending', false)).append('&nbsp;Nav'));
        $row.append(spendableRow)

        if (data.changes.spending !== 0) {
            let spendableChangeRow = $(document.createElement('td')).attr('class', 'text-right td-adaptive').attr('data-role', 'spendableChange')
            spendableChangeRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'spending', true)).append('&nbsp;Nav'));
            $row.append(spendableChangeRow)

            let spendableBalanceRow = $(document.createElement('td')).attr('class', 'text-right td-adaptive').attr('data-role', 'spendableBalance')
            spendableBalanceRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'spending', false)).append('&nbsp;Nav'));
            $row.append(spendableBalanceRow)
        }

        let stakableRow = $(document.createElement('td')).attr('class', 'text-right hide').attr('data-role', 'stakable')
        stakableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'staking', true)).append('&nbsp;Nav'));
        stakableRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'staking', false)).append('&nbsp;Nav'));
        $row.append(stakableRow)

        if (data.changes.staking !== 0) {
            let stakableChangeRow = $(document.createElement('td')).attr('class', 'td-adaptive').attr('data-role', 'stakableChange')
            stakableChangeRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'staking', true)).append('&nbsp;Nav'));
            $row.append(stakableChangeRow)

            let stakableBalanceRow = $(document.createElement('td')).attr('class', 'td-adaptive').attr('data-role', 'stakableBalance')
            stakableBalanceRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'staking', false)).append('&nbsp;Nav'));
            $row.append(stakableBalanceRow)
        }

        let votingRow = $(document.createElement('td')).attr('class', 'text-right hide').attr('data-role', 'votingWeight')
        votingRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'voting', true)).append('&nbsp;Nav'));
        votingRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'voting', false)).append('&nbsp;Nav'));
        $row.append(votingRow)

        if (data.changes.voting !== 0) {
            let votingChangeRow = $(document.createElement('td')).attr('class', 'text-right td-adaptive').attr('data-role', 'votingWeightChange')
            votingChangeRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.changes, 'voting', true)).append('&nbsp;Nav'));
            $row.append(votingChangeRow)

            let votingBalanceRow = $(document.createElement('td')).attr('class', 'text-right td-adaptive').attr('data-role', 'votingWeightBalance')
            votingBalanceRow.append($(document.createElement('div')).append(AddressIndexPage.addChanges(data.balance, 'voting', false)).append('&nbsp;Nav'));
            $row.append(votingBalanceRow)
        }

        return $row;
    }

    static addChanges(changes, value, sign) {
        let change = $(document.createElement('span'))

        if (changes[value] === 0) {
            // change.attr('class', 'zero')
        }
        if (sign === true && changes[value] > 0) {
            change.append('+ ');
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