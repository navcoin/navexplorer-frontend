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
            $data['staking'] !== 0 ? $data['staking'] / 100000000 : 0,
            $data['spending'] !== 0 ? $data['spending'] / 100000000 : 0,
            $data['voting'] !== 0 ? $data['voting'] / 100000000 : 0
        );
    }
}
