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
            isset($data['votes']['yes']) ? $data['votes']['yes'] : 0,
            isset($data['votes']['no']) ? $data['votes']['no'] : 0,
            isset($data['votes']['abstain']) ? $data['votes']['abstain'] : 0,
            isset($data['votes']['exclude']) ? $data['votes']['exclude'] : 0,
            isset($data['trend']['yes']) ? $data['trend']['yes'] : 0,
            isset($data['trend']['no']) ? $data['trend']['no'] : 0,
            isset($data['trend']['abstain']) ? $data['trend']['abstain'] : 0,
            isset($data['trend']['exclude']) ? $data['trend']['exclude'] : 0
        );
    }
}
