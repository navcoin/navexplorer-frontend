<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\DateRangeInterface;

class StakingGroup implements DateRangeInterface
{
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var int
     */
    private $stakes;

    /**
     * @var float
     */
    private $amount;

    public function __construct(
        \DateTime $start,
        \DateTime $end,
        int $stakes,
        float $amount
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->stakes = $stakes;
        $this->amount = $amount;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start)
    {
        $this->start = $start;
        return $this;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
        return $this;
    }

    public function getStakes(): int
    {
        return $this->stakes;
    }

    public function setStakes(int $stakes)
    {
        $this->stakes = $stakes;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
        return $this;
    }
    
    public function getRatio(float $balance): float
    {
        if ($balance == 0) {
            return 0;
        }

        return ($this->amount / $balance) * 100;
    }

    public function getRatioAnnualised(float $balance, string $period): float
    {
        if ($balance == 0) {
            return 0;
        }

        $ratio = $this->getRatio($balance);
        switch ($period) {
            case 'hourly':
                return $ratio * 8760;
            case 'daily':
                return $ratio * 365;
            case 'monthly':
                return $ratio * 12;
            default:
                return null;
        }
    }
}
