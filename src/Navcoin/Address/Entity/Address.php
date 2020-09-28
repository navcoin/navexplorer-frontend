<?php

namespace App\Navcoin\Address\Entity;

use DateTime;

class Address
{
    /** @var string */
    private $hash;

    /** @var int */
    private $height;

    /** @var float */
    private $spending;

    /** @var float */
    private $staking;

    /** @var float */
    private $voting;

    /** @var DateTime */
    private $createdTime;

    /** @var int */
    private $createdBlock;

    /** @var RichList */
    private $richList;

    public function __construct(
        string $hash,
        int $height,
        float $spending,
        float $staking,
        float $voting,
        DateTime $createdTime,
        int $createdBlock,
        RichList $richList
    ) {
        $this->hash = $hash;
        $this->height = $height;
        $this->spending = $spending;
        $this->staking = $staking;
        $this->voting = $voting;
        $this->createdTime = $createdTime;
        $this->createdBlock = $createdBlock;
        $this->richList = $richList;
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

    public function getCreatedTime(): DateTime
    {
        return $this->createdTime;
    }

    public function getCreatedBlock(): int
    {
        return $this->createdBlock;
    }

    public function getRichList(): RichList
    {
        return $this->richList;
    }
}
