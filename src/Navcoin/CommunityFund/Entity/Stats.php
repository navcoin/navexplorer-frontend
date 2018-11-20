<?php

namespace App\Navcoin\CommunityFund\Entity;

class Stats
{
    /**
     * @var float
     */
    private $available;

    /**
     * @var float
     */
    private $locked;

    public function __construct(float $available, float $locked)
    {
        $this->available = $available;
        $this->locked = $locked;
    }

    public function getAvailable(): float
    {
        return $this->available;
    }

    public function getLocked(): float
    {
        return $this->locked;
    }
}
