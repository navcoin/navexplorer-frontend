<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Address\Entity\Balance;
use App\Navcoin\Address\Entity\Changes;
use App\Navcoin\Address\Entity\MultiSig;
use App\Navcoin\Address\Entity\RichList;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Common\Mapper\MapperInterface;

class AddressMapper extends BaseMapper
{
    public function mapEntity(array $data): Address
    {
        $address = new Address(
            $data['hash'],
            $data['height'],
            $data['spendable'] / 100000000,
            $data['stakable'] / 100000000,
            $data['voting_weight'] / 100000000,
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['created_time']),
            $data['created_block'],
            $this->mapRichList($data['rich_list']),
            $this->mapMultiSig($this->getData("multisig", $data))
        );

        return $address;
    }

    public function mapRichList(array $data): RichList
    {
        return new RichList(
            $data['spendable'],
            $data['stakable'],
            $data['voting_weight']
        );
    }

    public function mapMultiSig(?array $data): ?MultiSig
    {
        if ($data == null) {
            return null;
        }
        return new MultiSig(
            $data['hash'],
            $data['signatures'],
            $data['required'],
            $data['total']
        );
    }
}
