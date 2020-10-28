<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\DateRangeInterface;
use DateTime;

class AddressGroup implements DateRangeInterface
{
    /** @var DateTime */
    private $start;

    /** @var DateTime */
    private $end;

    /** @var int */
    private $addresses;

    /** @var int */
    private $stake;

    /** @var int */
    private $spend;

    public function __construct(DateTime $start, DateTime $end, int $addresses, int $stake, int $spend)
    {
        $this->start = $start;
        $this->end = $end;
        $this->addresses = $addresses;
        $this->stake = $stake;
        $this->spend = $spend;
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    public function getEnd(): DateTime
    {
        return $this->end;
    }

    public function getAddresses(): int
    {
        return $this->addresses;
    }

    public function getStake(): int
    {
        return $this->stake;
    }

    public function getSpend(): int
    {
        return $this->spend;
    }
}
