<?php

namespace App\Navcoin\SoftFork\Entity;

use DateTime;

class SoftFork
{
    /** @var string */
    private $name;

    /** @var int */
    private $signalBit;

    /** @var string */
    private $state;

    /** @var DateTime */
    private $startTime;

    /** @var DateTime */
    private $timeout;

    /** @var int */
    private $lockedInHeight;

    /** @var int */
    private $activationHeight;

    /** @var int */
    private $signalHeight;

    /**
     * @var []string
     */
    private $cycles = [];

    public function __construct(
        String $name,
        int $signalBit,
        string $state,
        DateTime $startTime,
        DateTime $timeout,
        ?int $lockedInHeight,
        ?int $activationHeight,
        ?int $signalHeight
    ) {
        $this->name = $name;
        $this->signalBit = $signalBit;
        $this->state = $state;
        $this->startTime = $startTime;
        $this->timeout = $timeout;
        $this->lockedInHeight = $lockedInHeight;
        $this->activationHeight = $activationHeight;
        $this->signalHeight = $signalHeight;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSignalBit(): int
    {
        return $this->signalBit;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function getTimeout(): DateTime
    {
        return $this->timeout;
    }

    public function getLockedInHeight(): ?int
    {
        return $this->lockedInHeight;
    }

    public function getActivationHeight(): ?int
    {
        return $this->activationHeight;
    }

    public function getSignalHeight(): int
    {
        return $this->signalHeight;
    }

    public function addCycle(int $index, int $blocks) {
        $this->cycles[$index] = $blocks;
    }

    public function getBestCycle(): int {
        return count($this->cycles) > 0 ? end($this->cycles) : 0;
    }

    public function isSignalling(): bool {
        return in_array($this->state, ["defined", "started"]) && $this->timeout->getTimestamp() >= (new DateTime())->getTimestamp();
    }

    public function isActive(): bool {
        return in_array($this->state, ["active", "locked_in"]);
    }

    public function isExpired(): bool {
        return in_array($this->state, ["defined", "started"]) && $this->timeout->getTimestamp() < (new DateTime())->getTimestamp();
    }
}
