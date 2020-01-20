<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction as Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
       return new Transaction(
            $data['hash'],
            $data['txid'],
            $data['height'],
            $data['index'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['time']),
            $data['type'],
            $data['cold'],
            $data['input'] / 100000000,
            $data['output'] / 100000000,
            $data['total'] / 100000000,
            ($data['balance']) / 100000000
        );
    }
}
