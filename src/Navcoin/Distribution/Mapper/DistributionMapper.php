<?php

namespace App\Navcoin\Distribution\Mapper;

use App\Navcoin\Common\Mapper\MapperInterface;
use App\Navcoin\Distribution\Entity\Distribution;
use App\Navcoin\Distribution\Entity\DistributionSegment;

/**
 * Class DistributionMapper
 *
 * @package App\Navcoin\Mapper
 */
class DistributionMapper implements MapperInterface
{
    /**
     * Map distribution
     *
     * @param array       $data
     * @param String|null $class
     *
     * @return Distribution
     */
    public function mapIterator(array $data, String $class = null)
    {
        $distribution = new Distribution();

        foreach ($data as $segment) {
            $distribution->add($this->mapEntity($segment));
        }

        return $distribution;
    }

    /**
     * Map Segment
     *
     * @param array $data
     *
     * @return DistributionSegment
     */
    public function mapEntity(array $data): DistributionSegment
    {
        return new DistributionSegment(
            $data['position'],
            $data['total']  / 100000000,
            $data['value']  / 100000000,
            round($data['percentage'], 2)
        );
    }
}
