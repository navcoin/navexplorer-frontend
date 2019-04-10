<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction as Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
        if ($data['type'] === 'COLD_STAKING') {
            $coldStakingBalance = $data['coldStakingBalance'];
            $coldStakingSent = ($data['type'] !== 'RECEIVE' ? $data['coldStakingSent'] : 0);
            $coldStakingReceived = $data['coldStakingReceived'];
            $coldStakingAmount = ($data['coldStakingReceived'] - $coldStakingSent);
        }

        return new Transaction(
            $data['transaction'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['time']),
            $data['height'],
            $data['balance'] / 100000000,
            $data['sent'] / 100000000,
            $data['received'] / 100000000,
            ($data['received'] - $data['sent']) / 100000000,
            $data['type'],
            $data['address'],
            isset($coldStakingBalance) ? $coldStakingBalance / 100000000 : 0,
            isset($coldStakingSent)? $coldStakingSent / 100000000 : 0,
            isset($coldStakingReceived) ? $coldStakingReceived / 100000000 : 0,
            isset($coldStakingAmount) ? $coldStakingAmount / 100000000 : 0
        );
    }
}
