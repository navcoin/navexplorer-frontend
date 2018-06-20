<?php

namespace App\Navcoin\Distribution\Entity;

/**
 * Class Distribution
 *
 * @package App\Navcoin\Distribution\Entity
 */
class Distribution implements \IteratorAggregate
{
    /**
     * @var DistributionSegment[]
     */
    private $segments = [];

    /**
     * Add
     *
     * @param DistributionSegment $segment
     *
     * @return Distribution
     */
    public function add(DistributionSegment $segment): self
    {
        array_push($this->segments, $segment);

        return $this;
    }

    /**
     * Get Iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->segments);
    }
}
