<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Common\Mapper\MapperInterface;

/**
 * Class AddressMapper
 *
 * @package App\Navcoin\Address\Mapper
 */
class AddressMapper implements MapperInterface
{
    /**
     * Map Addresses
     *
     * @param array       $data
     * @param String|null $class
     *
     * @return array
     */
    public function mapIterator(array $data, String $class = null): array
    {
        $addresses = [];
        foreach ($data as $address) {
            $addresses[] = $this->mapEntity($address);
        }

        return $addresses;
    }

    /**
     * Map Address
     *
     * @param array $data
     *
     * @return Address
     */
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
            $data['label']
        );
    }
}
