<?php

namespace App\Navcoin\CommunityFund\Entity;

class Stats
{
    /**
     * @var float
     */
    private $contributed;

    /**
     * @var float
     */
    private $requested;

    /**
     * @var float
     */
    private $paid;

    /**
     * @var float
     */
    private $locked;

    public function __construct(float $contributed, float $requested, float $paid, float $locked)
    {
        $this->contributed = $contributed;
        $this->requested = $requested;
        $this->paid = $paid;
        $this->locked = $locked;
    }

    public function getContributed(): float
    {
        return $this->contributed;
    }

    public function getRequested(): float
    {
        return $this->requested;
    }

    public function getPaid(): float
    {
        return $this->paid;
    }

    public function getLocked(): float
    {
        return $this->locked;
    }

    public function getAvailable(): float
    {
        return $this->contributed - $this->paid - $this->locked;
    }
}
