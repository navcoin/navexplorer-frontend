<?php

namespace App\Navcoin\Address\Entity;

class Summary
{
    /** @var int */
    protected $height;

    /** @var string */
    private $hash;

    /** @var SummaryAccount */
    private $spending;

    /** @var SummaryAccount */
    private $staking;

    /** @var SummaryAccount */
    private $voting;

    public function __construct(int $height, string $hash, SummaryAccount $spending, SummaryAccount $staking, SummaryAccount $voting)
    {
        $this->height = $height;
        $this->hash = $hash;
        $this->spending = $spending;
        $this->staking = $staking;
        $this->voting = $voting;
    }


    public function getHeight(): int
    {
        return $this->height;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return SummaryAccount
     */
    public function getSpending(): SummaryAccount
    {
        return $this->spending;
    }

    /**
     * @return SummaryAccount
     */
    public function getStaking(): SummaryAccount
    {
        return $this->staking;
    }

    /**
     * @return SummaryAccount
     */
    public function getVoting(): SummaryAccount
    {
        return $this->voting;
    }
}