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
    private $blocksSignalling;

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
        ?int $blocksSignalling,
        ?int $lockedInHeight,
        ?int $activationHeight
    ) {
        $this->name = $name;
        $this->state = $state;
        $this->blocksSignalling = $blocksSignalling;
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

    public function getBlocksSignalling(): int
    {
        return $this->blocksSignalling;
    }

    public function getLockedInHeight(): ?int
    {
        return $this->lockedInHeight;
    }

    public function getActivationHeight(): ?int
    {
        return $this->activationHeight;
    }
}
