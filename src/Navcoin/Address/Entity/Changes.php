<?php

namespace App\Navcoin\Address\Entity;

class Changes
{
    /** @var float */
    private $spendable;

    /** @var float */
    private $stakable;

    /** @var float */
    private $votingWeight;

    public function __construct(float $spendable, float $stakable, float $votingWeight)
    {
        $this->spendable = $spendable;
        $this->stakable = $stakable;
        $this->votingWeight = $votingWeight;
    }

    public function getSpendable(): float
    {
        return $this->spendable;
    }

    public function getStakable(): float
    {
        return $this->stakable;
    }

    public function getVotingWeight(): float
    {
        return $this->votingWeight;
    }
}