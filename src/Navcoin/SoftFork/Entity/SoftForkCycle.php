<?php

namespace App\Navcoin\SoftFork\Entity;

class SoftForkCycle
{
    /**
     * @var int
     */
    private $blocksInCycle;

    /**
     * @var int
     */
    private $blockCycle;

    /**
     * @var int
     */
    private $currentBlock;

    /**
     * @var int
     */
    private $firstBlock;

    /**
     * @var int
     */
    private $remainingBlocks;

    public function __construct(int $blocksInCycle, int $blockCycle, int $currentBlock, int $firstBlock, int $remainingBlocks)
    {
        $this->blocksInCycle = $blocksInCycle;
        $this->blockCycle = $blockCycle;
        $this->currentBlock = $currentBlock;
        $this->firstBlock = $firstBlock;
        $this->remainingBlocks = $remainingBlocks;
    }

    public function getBlocksInCycle(): int
    {
        return $this->blocksInCycle;
    }

    public function getBlockCycle(): int
    {
        return $this->blockCycle;
    }

    public function getCurrentBlock(): int
    {
        return $this->currentBlock;
    }

    public function getFirstBlock(): int
    {
        return $this->firstBlock;
    }

    public function getRemainingBlocks(): int
    {
        return $this->remainingBlocks;
    }
}