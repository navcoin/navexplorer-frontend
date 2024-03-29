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
    private $spendable;

    /** @var float */
    private $stakable;

    /** @var float */
    private $votingWeight;

    /** @var DateTime */
    private $createdTime;

    /** @var int */
    private $createdBlock;

    /** @var RichList */
    private $richList;

    /** @var array */
    private $meta;

    public function __construct(
        string $hash,
        int $height,
        float $spendable,
        float $stakable,
        float $votingWeight,
        DateTime $createdTime,
        int $createdBlock,
        RichList $richList,
        ?MultiSig $multiSig,
        ?array $meta
    ) {
        $this->hash = $hash;
        $this->height = $height;
        $this->spendable = $spendable;
        $this->stakable = $stakable;
        $this->votingWeight = $votingWeight;
        $this->createdTime = $createdTime;
        $this->createdBlock = $createdBlock;
        $this->richList = $richList;
        $this->multiSig = $multiSig;
        $this->meta = $meta;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getSpendable(): float
    {
        return $this->spendable;
    }

    public function getStakable(): float
    {
        return $this->stakable;
    }

    public function getVotingWeight(): float
    {
        return $this->votingWeight;
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

    public function isMultiSig(): bool
    {
        return $this->multiSig != null;
    }

    public function getMultiSig(): MultiSig
    {
        return $this->multiSig;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

}
