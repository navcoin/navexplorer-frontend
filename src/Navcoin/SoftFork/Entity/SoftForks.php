<?php

namespace App\Navcoin\SoftFork\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\SoftFork\Exception\SoftForkNotFoundException;

class SoftForks extends IteratorEntity implements IteratorEntityInterface
{
    /**
     * @var int
     */
    private $blockCycle;

    /**
     * @var int
     */
    private $blocksInCycle;

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
    private $blocksRemaining;

    public function __construct(int $blockCycle, int $blocksInCycle, int $firstBlock, int $currentBlock, int $blocksRemaining)
    {
        parent::__construct();

        $this->blockCycle = $blockCycle;
        $this->blocksInCycle = $blocksInCycle;
        $this->firstBlock = $firstBlock;
        $this->currentBlock = $currentBlock;
        $this->blocksRemaining = $blocksRemaining;
    }

    public function setSupportedTypes()
    {
        $this->supportedTypes = [SoftFork::class];
    }

    public function sortByLockedInHeight() {
        $softForks = $this->getElements();
        usort($softForks, function (SoftFork $a, SoftFork $b) {
            return -1 * ($a->getLockedInHeight() - $b->getLockedInHeight());
        });

        $this->setElements($softForks);
    }

    public function getBlockCycle(): int
    {
        return $this->blockCycle;
    }

    public function getBlocksInCycle(): int
    {
        return $this->blocksInCycle;
    }

    public function getFirstBlock(): int
    {
        return $this->firstBlock;
    }

    public function getCurrentBlock(): int
    {
        return $this->currentBlock;
    }

    public function getBlocksRemaining(): int
    {
        return $this->blocksRemaining;
    }
}

