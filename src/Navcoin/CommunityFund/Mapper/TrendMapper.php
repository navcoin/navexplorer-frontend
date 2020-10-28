<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Trend;

class TrendMapper extends BaseMapper
{
    public function mapEntity(array $data): Trend
    {
        return new Trend(
            $data['start'],
            $data['end'],
            $data['votes']['yes'],
            $data['votes']['no'],
            $data['votes']['abstain'],
            $data['trend']['yes'],
            $data['trend']['no'],
            $data['trend']['abstain']
        );
    }
}
