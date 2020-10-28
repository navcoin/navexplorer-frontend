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
            $data['stakable'] !== 0 ? $data['stakable'] / 100000000 : 0,
            $data['spendable'] !== 0 ? $data['spendable'] / 100000000 : 0,
            $data['voting_weight'] !== 0 ? $data['voting_weight'] / 100000000 : 0
        );
    }
}
