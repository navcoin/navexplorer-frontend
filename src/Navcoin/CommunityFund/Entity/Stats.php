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

    /**
     * @var float
     */
    private $spent;

    public function __construct(float $available, float $locked, float $spent)
    {
        $this->available = $available;
        $this->locked = $locked;
        $this->spent = $spent;
    }

    public function getAvailable(): float
    {
        return $this->available;
    }

    public function getLocked(): float
    {
        return $this->locked;
    }

    public function getSpent(): float
    {
        return $this->spent;
    }
}
