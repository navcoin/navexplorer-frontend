<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Common\Mapper\MapperInterface;

class AddressMapper implements MapperInterface
{
    public function mapIterator(array $data, String $class = null): array
    {
        $addresses = [];
        foreach ($data as $address) {
            $addresses[] = $this->mapEntity($address);
        }

        return $addresses;
    }

    public function mapEntity(array $data): Address
    {
        return new Address(
            $data['hash'],
            $data['received'] / 100000000,
            $data['receivedCount'],
            $data['sent'] / 100000000,
            $data['sentCount'],
            $data['staked'] / 100000000,
            $data['stakedCount'],
            $data['stakedSent'] / 100000000,
            $data['balance'] / 100000000,
            $data['blockIndex'],
            $data['richListPosition'],
            $data['coldStakedBalance'] / 100000000,
            $data['coldStaked'] / 100000000,
            $data['coldStakedCount'],
            $data['coldStakedSent'] / 100000000,
            array_key_exists('label', $data) ? $data['label'] : null
        );
    }
}
