<?php

namespace App\Navcoin\Distribution\Entity;

class DistributionSegment
{
    /**
     * @var int
     */
    private $group;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var int
     */
    private $percentage;

    public function __construct(int $group, float $balance, int $percentage)
    {
        $this->group = $group;
        $this->balance = $balance;
        $this->percentage = $percentage;
    }

    public function getGroup(): int
    {
        return $this->group;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }
}