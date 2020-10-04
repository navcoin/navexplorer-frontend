<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressGroup;
use App\Navcoin\Common\Mapper\BaseMapper;

class AddressGroupMapper extends BaseMapper
{
    public function mapEntity(array $data): AddressGroup
    {
        return new AddressGroup(
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['start']),
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['end']),
            $data['addresses'],
            $data['stake'],
            $data['spend']
        );
    }
}
