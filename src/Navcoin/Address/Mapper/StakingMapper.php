<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\StakingGroup;
use App\Navcoin\Common\Mapper\BaseMapper;

class StakingMapper extends BaseMapper
{
    public function mapEntity(array $data): StakingGroup
    {
        return new StakingGroup(
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['start']),
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['end']),
            $data['stakes'],
            $data['amount'] !== 0 ? $data['amount'] / 100000000 : 0
        );
    }
}
