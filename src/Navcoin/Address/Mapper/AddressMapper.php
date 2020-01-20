<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Common\Mapper\MapperInterface;

class AddressMapper extends BaseMapper
{
    public function mapEntity(array $data): Address
    {
        return new Address(
            $data['hash'],
            array_key_exists('received', $data) && $data['received'] !== 0 ? ($data['received'] / 100000000) : 0,
            array_key_exists('receivedCount', $data) ? $data['receivedCount'] : 0,
            array_key_exists('sent', $data) && $data['sent'] !== 0 ? ($data['sent'] / 100000000) : 0,
            array_key_exists('sentCount', $data) ? $data['sentCount'] : 0,
            array_key_exists('staked', $data) && $data['staked'] !== 0 ? ($data['staked'] / 100000000) : 0,
            array_key_exists('stakedCount', $data) ? $data['stakedCount'] : 0,
            array_key_exists('stakedSent', $data) && $data['stakedSent'] !== 0 ? ($data['stakedSent'] / 100000000) : 0,
            array_key_exists('balance', $data) && $data['balance'] !== 0 ? ($data['balance'] / 100000000) : 0,
            array_key_exists('height', $data) ? $data['height'] : 0,
            array_key_exists('position', $data) ? $data['position'] : 0,
            array_key_exists('coldBalance', $data) && $data['coldBalance'] !== 0 ? ($data['coldBalance'] / 100000000) : 0,
            array_key_exists('coldStaked', $data) && $data['coldStaked'] !== 0 ? ($data['coldStaked'] / 100000000) : 0,
            array_key_exists('coldStakedCount', $data) ? $data['coldStakedCount'] : 0,
            array_key_exists('coldStakedSent', $data) && $data['coldStakedSent'] !== 0 ? ($data['coldStakedSent'] / 100000000) : 0,
            array_key_exists('label', $data) ? $data['label'] : null
        );
    }
}
