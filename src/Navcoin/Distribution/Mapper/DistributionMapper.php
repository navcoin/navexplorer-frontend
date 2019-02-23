<?php

namespace App\Navcoin\Distribution\Mapper;

use App\Navcoin\Common\Entity\Paginator;
use App\Navcoin\Common\Mapper\MapperInterface;
use App\Navcoin\Distribution\Entity\Distribution;
use App\Navcoin\Distribution\Entity\DistributionSegment;

class DistributionMapper implements MapperInterface
{
    public function mapIterator(String $class, array $data, Paginator $paginator = null, array $options = [])
    {
        $distribution = new Distribution();

        foreach ($data as $segment) {
            $distribution->add($this->mapEntity($segment));
        }

        return $distribution;
    }

    public function mapEntity(array $data): DistributionSegment
    {
        return new DistributionSegment(
            $data['group'],
            $data['balance']  / 100000000,
            $data['percentage']
        );
    }
}
