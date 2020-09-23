<?php

namespace App\Navcoin\Address\Entity;

class Address
{
    /** @var int */
    protected $position;

    /** @var string */
    private $hash;

    /** @var int */
    protected $height;

    /** @var float */
    protected $spending;

    /** @var float */
    protected $staking;

    /** @var float */
    protected $voting;

    public function __construct(int $position, string $hash, int $height, float $spending, float $staking, float $voting) {
        $this->position = $position;
        $this->hash = $hash;
        $this->height = $height;
        $this->spending = $spending;
        $this->staking = $staking;
        $this->voting = $voting;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getSpending(): float
    {
        return $this->spending;
    }

    public function getStaking(): float
    {
        return $this->staking;
    }

    public function getVoting(): float
    {
        return $this->voting;
    }
}
