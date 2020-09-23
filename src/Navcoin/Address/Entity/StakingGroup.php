<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\DateRangeInterface;

class StakingGroup implements DateRangeInterface
{
    /** @var \DateTime */
    private $start;

    /** @var \DateTime */
    private $end;

    /** @var int */
    private $stakes;

    /** @var float */
    private $staking;

    /** @var float */
    private $spending;

    /** @var float */
    private $voting;

    public function __construct(
        \DateTime $start,
        \DateTime $end,
        int $stakes,
        float $staking,
        float $spending,
        float $voting
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->stakes = $stakes;
        $this->staking = $staking;
        $this->spending = $spending;
        $this->voting = $voting;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getStakes(): int
    {
        return $this->stakes;
    }

    public function getStaking(): float
    {
        return $this->staking;
    }

    public function getSpending(): float
    {
        return $this->spending;
    }

    public function getVoting(): float
    {
        return $this->voting;
    }

    
    public function getSpendingRatio(float $balance): float
    {
        if ($balance == 0 || $this->spending == 0) {
            return 0;
        }

        return ($this->spending / $balance) * 100;
    }


    public function getStakingRatio(float $balance): float
    {
        if ($balance == 0 || $this->staking == 0) {
            return 0;
        }

        return ($this->staking / $balance) * 100;
    }


    public function getVotingRatio(float $balance): float
    {
        if ($balance == 0 || $this->voting == 0) {
            return 0;
        }

        return ($this->voting / $balance) * 100;
    }

    public function getSpendingRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getSpendingRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
        }
    }

    public function getStakingRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getStakingRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
        }
    }

    public function getVotingRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getVotingRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
        }
    }
}
