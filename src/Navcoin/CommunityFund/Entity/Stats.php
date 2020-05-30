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
    private $available;

    /**
     * @var float
     */
    private $paid;

    /**
     * @var float
     */
    private $locked;

    public function __construct(float $contributed, float $available, float $paid, float $locked)
    {
        $this->contributed = $contributed - 5.00030464;
        $this->available = $available - 5.00030464;
        $this->paid = $paid;
        $this->locked = $locked;
    }

    public function getContributed(): float
    {
        return $this->contributed;
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
        return $this->available;
    }
}
