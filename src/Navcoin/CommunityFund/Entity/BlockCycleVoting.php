<?php

namespace App\Navcoin\CommunityFund\Entity;

class BlockCycleVoting
{
    /**
     * @var int
     */
    private $cycles;

    /**
     * @var float
     */
    private $accept;

    /**
     * @var float
     */
    private $reject;

    public function __construct(int $cycles, float $accept, float $reject)
    {
        $this->cycles = $cycles;
        $this->accept = $accept;
        $this->reject = $reject;
    }

    public function getCycles(): int
    {
        return $this->cycles;
    }

    public function getAccept(): float
    {
        return $this->accept;
    }

    public function getReject(): float
    {
        return $this->reject;
    }


}
