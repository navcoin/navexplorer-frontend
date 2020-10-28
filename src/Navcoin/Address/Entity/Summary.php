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
    private $spendable;

    /** @var SummaryAccount */
    private $stakable;

    /** @var SummaryAccount */
    private $votingWeight;

    public function __construct(int $height, string $hash, int $txs, SummaryAccount $spendable, SummaryAccount $stakable, SummaryAccount $votingWeight)
    {
        $this->height = $height;
        $this->hash = $hash;
        $this->txs = $txs;
        $this->spendable = $spendable;
        $this->stakable = $stakable;
        $this->votingWeight = $votingWeight;
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

    public function getSpendable(): SummaryAccount
    {
        return $this->spendable;
    }

    public function getStakable(): SummaryAccount
    {
        return $this->stakable;
    }

    public function getVotingWeight(): SummaryAccount
    {
        return $this->votingWeight;
    }
}