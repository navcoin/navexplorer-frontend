<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Transaction;
use App\Navcoin\Address\Entity\Transactions;
use App\Navcoin\Common\Mapper\BaseMapper;

/**
 * Class TransactionMapper
 *
 * @package App\Navcoin\Address\Mapper
 */
class TransactionMapper extends BaseMapper
{
    /**
     * Map Address
     *
     * @param array $data
     *
     * @return Transaction
     */
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
            $data['amount'] / 100000000,
            $data['type']
        );
    }
}
