<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction as Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
        return new Transaction(
            $data['transaction'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['time']),
            $data['height'],
            $data['balance'] / 100000000,
            $data['sent'] / 100000000,
            $data['received'] / 100000000,
            $data['type'],
            $data['address'],
            $data['coldStakingBalance'] / 100000000,
            $data['coldStakingSent'] / 100000000,
            $data['coldStakingReceived'] / 100000000
        );
    }
}
