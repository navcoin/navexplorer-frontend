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
    private $stakable;

    /** @var float */
    private $spendable;

    /** @var float */
    private $votingWeight;

    public function __construct(
        \DateTime $start,
        \DateTime $end,
        int $stakes,
        float $stakable,
        float $spendable,
        float $votingWeight
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->stakes = $stakes;
        $this->stakable = $stakable;
        $this->spendable = $spendable;
        $this->votingWeight = $votingWeight;
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

    public function getStakable(): float
    {
        return $this->stakable;
    }

    public function getSpendable(): float
    {
        return $this->spendable;
    }

    public function getVotingWeight(): float
    {
        return $this->votingWeight;
    }

    
    public function getSpendableRatio(float $balance): float
    {
        if ($balance == 0 || $this->spendable == 0) {
            return 0;
        }

        return ($this->spendable / $balance) * 100;
    }


    public function getStakableRatio(float $balance): float
    {
        if ($balance == 0 || $this->stakable == 0) {
            return 0;
        }

        return ($this->stakable / $balance) * 100;
    }


    public function getVotingWeightRatio(float $balance): float
    {
        if ($balance == 0 || $this->votingWeight == 0) {
            return 0;
        }

        return ($this->votingWeight / $balance) * 100;
    }

    public function getSpendableRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getSpendableRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
        }
    }

    public function getStakableRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getStakableRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
        }
    }

    public function getVotingWeightRatioAnnualised(float $balance, string $period): float
    {
        $ratio = $this->getVotingWeightRatio($balance);
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
