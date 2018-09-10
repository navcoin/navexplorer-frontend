<?php

namespace App\Navcoin\CommunityFund\Entity;

class BlockCycle
{
    /**
     * @var int
     */
    private $blocksInCycle;

    /**
     * @var float
     */
    private $minQuorum;

    /**
     * @var BlockCycleVoting
     */
    private $proposalVoting;

    /**
     * @var BlockCycleVoting
     */
    private $paymentVoting;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $cycle;

    /**
     * @var int
     */
    private $firstBlock;

    /**
     * @var int
     */
    private $currentBlock;

    /**
     * @var int
     */
    private $remainingBlocks;

    public function __construct(
        int $blocksInCycle,
        float $minQuorum,
        BlockCycleVoting $proposalVoting,
        BlockCycleVoting $paymentVoting,
        int $height,
        int $cycle,
        int $firstBlock,
        int $currentBlock,
        int $remainingBlocks
    ) {
        $this->blocksInCycle = $blocksInCycle;
        $this->minQuorum = $minQuorum;
        $this->proposalVoting = $proposalVoting;
        $this->paymentVoting = $paymentVoting;
        $this->height = $height;
        $this->cycle = $cycle;
        $this->firstBlock = $firstBlock;
        $this->currentBlock = $currentBlock;
        $this->remainingBlocks = $remainingBlocks;
    }

    public function getBlocksInCycle(): int
    {
        return $this->blocksInCycle;
    }

    public function getMinQuorum(): float
    {
        return $this->minQuorum;
    }

    public function getProposalVoting(): BlockCycleVoting
    {
        return $this->proposalVoting;
    }

    public function getPaymentVoting(): BlockCycleVoting
    {
        return $this->paymentVoting;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getCycle(): int
    {
        return $this->cycle;
    }

    public function getFirstBlock(): int
    {
        return $this->firstBlock;
    }

    public function getCurrentBlock(): int
    {
        return $this->currentBlock;
    }

    public function getRemainingBlocks(): int
    {
        return $this->remainingBlocks;
    }
}
