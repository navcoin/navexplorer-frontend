<?php

namespace App\Navcoin\Address\Entity;

class Changes
{
    /** @var float */
    private $spending;

    /** @var float */
    private $staking;

    /** @var float */
    private $voting;

    public function __construct(float $spending, float $staking, float $voting)
    {
        $this->spending = $spending;
        $this->staking = $staking;
        $this->voting = $voting;
    }

    public function getSpending(): float
    {
        return $this->spending;
    }

    public function getStaking(): float
    {
        return $this->staking;
    }

    public function getVoting(): float
    {
        return $this->voting;
    }
}