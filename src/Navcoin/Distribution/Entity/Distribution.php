<?php

namespace App\Navcoin\Distribution\Entity;

class Distribution implements \IteratorAggregate
{
    /**
     * @var DistributionSegment[]
     */
    private $segments = [];

    public function add(DistributionSegment $segment): self
    {
        array_push($this->segments, $segment);

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->segments);
    }
}
