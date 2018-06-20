<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\BlockGroup;
use App\Navcoin\Common\Mapper\BaseMapper;

/**
 * Class BlockGroupMapper
 *
 * @package App\Navcoin\Block\Mapper
 */
class BlockGroupMapper extends BaseMapper
{
    /**
     * @param array $data
     *
     * @return BlockGroup
     */
    public function mapEntity(array $data): BlockGroup
    {
        return new BlockGroup(
            $data['group']['category'],
            (new \DateTime())->setTimestamp($data['group']['start']/1000),
            (new \DateTime())->setTimestamp($data['group']['end']/1000),
            $data['group']['secondsInPeriod'],
            $data['blocks'],
            $data['transactions'],
            $data['stake'] / 100000000,
            $data['fees'] / 100000000,
            $data['spend'] / 100000000,
            $data['height']
        );
    }
}
