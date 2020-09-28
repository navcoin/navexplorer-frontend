<?php

namespace App\Navcoin\Address\Entity;

class RichList
{
    /** @var int */
    private $spending;
    /** @var int */

    private $staking;

    /** @var int */
    private $voting;

    public function __construct(int $spending, int $staking, int $voting)
    {
        $this->spending = $spending;
        $this->staking = $staking;
        $this->voting = $voting;
    }

    public function getSpending(): int
    {
        return $this->spending;
    }

    public function getStaking(): int
    {
        return $this->staking;
    }

    public function getVoting(): int
    {
        return $this->voting;
    }
}