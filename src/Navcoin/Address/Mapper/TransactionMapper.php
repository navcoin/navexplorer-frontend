<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction;
use App\Navcoin\Address\Entity\ColdStakingTransaction;
use App\Navcoin\Address\Entity\SpendingTransaction;
use App\Navcoin\Address\Entity\TransactionInterface;
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
     * @return AddressTransaction
     */
    public function mapEntity(array $data): AddressTransaction
    {
        return new AddressTransaction(
            $data['id'],
            $data['transaction'],
            $data['time']/1000,
            $data['height'],
            $data['balance'] / 100000000,
            $data['sent'] / 100000000,
            $data['received'] / 100000000,
            $data['type'],
            $data['address'],
            $data['coldStaking'],
            $data['coldStakingAddress']
        );
    }
}
