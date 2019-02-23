<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\BlockGroup;
use App\Navcoin\Common\Mapper\BaseMapper;

class BlockGroupMapper extends BaseMapper
{
    public function mapEntity(array $data): BlockGroup
    {
        return new BlockGroup(
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['start']),
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['end']),
            $data['blocks'],
            $data['transactions'],
            $data['stake'] ? $data['stake'] / 100000000 : 0,
            $data['fees'] ? $data['fees'] / 100000000 : 0,
            $data['spend'] ? $data['spend'] / 100000000 : 0,
            $data['height']
        );
    }
}
