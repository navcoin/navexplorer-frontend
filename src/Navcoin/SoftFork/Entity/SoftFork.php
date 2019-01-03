<?php

namespace App\Navcoin\SoftFork\Entity;

class SoftFork
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $state;

    /**
     * @var int
     */
    private $blocksInCycle;

    /**
     * @var int
     */
    private $blockRequired;

    /**
     * @var int
     */
    private $blocksSignalling;

    /**
     * @var int
     */
    private $blocksRemaining;

    /**
     * @var int
     */
    private $lockedInHeight;

    /**
     * @var int
     */
    private $activationHeight;

    public function __construct(
        String $name,
        String $state,
        int $blocksInCycle,
        ?int $blockRequired,
        ?int $blocksSignalling,
        ?int $blocksRemaining,
        ?int $lockedInHeight,
        ?int $activationHeight
    ) {
        $this->name = $name;
        $this->state = $state;
        $this->blocksInCycle = $blocksInCycle;
        $this->blockRequired = $blockRequired;
        $this->blocksSignalling = $blocksSignalling;
        $this->blocksRemaining = $blocksRemaining;
        $this->lockedInHeight = $lockedInHeight;
        $this->activationHeight = $activationHeight;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getBlocksInCycle(): int
    {
        return $this->blocksInCycle;
    }

    public function getBlockRequired()
    {
        return $this->blockRequired;
    }

    public function getBlocksSignalling(): int
    {
        return $this->blocksSignalling;
    }

    public function getBlocksRemaining(): int
    {
        return $this->blocksRemaining;
    }

    public function getLockedInHeight(): int
    {
        return $this->lockedInHeight ?: 0;
    }

    public function getActivationHeight(): int
    {
        return $this->activationHeight;
    }

    public function getPercentComplete(): int
    {
        if ($this->blocksSignalling == 0) {
            return 0;
        }

        return ($this->blocksSignalling / $this->blocksInCycle) * 100;
    }
}
