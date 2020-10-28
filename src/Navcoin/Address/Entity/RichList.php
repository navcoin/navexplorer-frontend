<?php

namespace App\Navcoin\Address\Entity;

class RichList
{
    /** @var int */
    private $spendable;

    /** @var int */
    private $stakable;

    /** @var int */
    private $votingWeight;

    public function __construct(int $spending, int $staking, int $voting)
    {
        $this->spendable = $spending;
        $this->stakable = $staking;
        $this->votingWeight = $voting;
    }

    public function getSpendable(): int
    {
        return $this->spendable;
    }

    public function getStakable(): int
    {
        return $this->stakable;
    }

    public function getVotingWeight(): int
    {
        return $this->votingWeight;
    }
}