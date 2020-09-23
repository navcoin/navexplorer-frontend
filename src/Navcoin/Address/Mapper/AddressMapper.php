<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Address\Entity\Balance;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Common\Mapper\MapperInterface;

class AddressMapper extends BaseMapper
{
    public function mapEntity(array $data): Address
    {
        return new Address(
            $data['position'],
            $data['hash'],
            $data['height'],
            $data['spending'] / 100000000,
            $data['staking'] / 100000000,
            $data['voting'] / 100000000
        );
    }
}
