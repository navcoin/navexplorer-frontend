<?php

namespace App\Navcoin\Address\Entity;

class Summary
{
    /** @var int */
    protected $height;

    /** @var string */
    private $hash;

    /** @var int */
    protected $txs;

    /** @var SummaryAccount */
    private $spending;

    /** @var SummaryAccount */
    private $staking;

    /** @var SummaryAccount */
    private $voting;

    public function __construct(int $height, string $hash, int $txs, SummaryAccount $spending, SummaryAccount $staking, SummaryAccount $voting)
    {
        $this->height = $height;
        $this->hash = $hash;
        $this->txs = $txs;
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

    public function getTxs(): int
    {
        return $this->txs;
    }

    public function getSpending(): SummaryAccount
    {
        return $this->spending;
    }

    public function getStaking(): SummaryAccount
    {
        return $this->staking;
    }

    public function getVoting(): SummaryAccount
    {
        return $this->voting;
    }
}