<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction as Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
        return new Transaction(
            $data['id'],
            $data['transaction'],
            $data['time']/1000,
            $data['height'],
            $data['balance'] / 100000000,
            $data['sent'] / 100000000,
            $data['received'] / 100000000,
            $data['type'],
            $data['address']
        );
    }
}
