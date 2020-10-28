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

    /**
     * @var float
     */
    private $quorum;

    public function __construct(int $cycles, float $accept, float $reject, float $quorum)
    {
        $this->cycles = $cycles;
        $this->accept = $accept;
        $this->reject = $reject;
        $this->quorum = $quorum;
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

    public function getQuorum(): float
    {
        return $this->quorum;
    }
}
