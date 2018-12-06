<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Trend;

class TrendMapper extends BaseMapper
{
    public function mapEntity(array $data): Trend
    {
        return new Trend(
            $data['votesYes'],
            $data['votesNo'],
            $data['segment'],
            $data['start'],
            $data['end'],
            $data['blocksCounted']
        );
    }
}
