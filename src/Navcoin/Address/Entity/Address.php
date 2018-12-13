<?php

namespace App\Navcoin\Address\Entity;

class Address
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @var float
     */
    private $received;

    /**
     * @var int
     */
    private $receivedCount;

    /**
     * @var float
     */
    private $sent;

    /**
     * @var int
     */
    private $sentCount;

    /**
     * @var float
     */
    private $staked;

    /**
     * @var int
     */
    private $stakedCount;

    /**
     * @var float
     */
    private $stakedSent;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var int
     */
    private $blockIndex;

    /**
     * @var int
     */
    private $richListPosition;

    /**
     * @var null|string
     */
    private $label;

    /**
     * @var float
     */
    private $coldStakedBalance;

    /**
     * @var float
     */
    private $coldStaked;

    /**
     * @var int
     */
    private $coldStakedCount;

    /**
     * @var float
     */
    private $coldStakedSent;

    public function __construct(
        string $hash,
        float $received,
        int $receivedCount,
        float $sent,
        int $sentCount,
        float $staked,
        int $stakedCount,
        float $stakeSent,
        float $balance,
        int $blockIndex,
        int $richListPosition,
        float $coldStakedBalance,
        float $coldStaked,
        int $coldStakedCount,
        float $coldStakeSent,
        ?string $label
    ) {
        $this->hash = $hash;
        $this->received = $received;
        $this->receivedCount = $receivedCount;
        $this->sent = $sent;
        $this->sentCount = $sentCount;
        $this->staked = $staked;
        $this->stakedCount = $stakedCount;
        $this->stakedSent = $stakeSent;
        $this->balance = $balance;
        $this->blockIndex = $blockIndex;
        $this->richListPosition = $richListPosition;
        $this->coldStakedBalance = $coldStakedBalance;
        $this->coldStaked = $coldStaked;
        $this->coldStakedCount = $coldStakedCount;
        $this->coldStakedSent = $coldStakeSent;
        $this->label = $label;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getReceived(): float
    {
        return $this->received;
    }

    public function getReceivedCount(): int
    {
        return $this->receivedCount;
    }

    public function getSent(): float
    {
        return $this->sent;
    }

    public function getSentCount(): int
    {
        return $this->sentCount;
    }

    public function getStaked(): float
    {
        return $this->staked;
    }

    public function getStakedCount(): int
    {
        return $this->stakedCount;
    }

    public function getStakedSent(): float
    {
        return $this->stakedSent;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getBlockIndex(): int
    {
        return $this->blockIndex;
    }

    public function getRichListPosition(): int
    {
        return $this->richListPosition;
    }

    public function getTransactions(): int
    {
        return $this->sentCount + $this->receivedCount + $this->stakedCount;
    }

    public function getColdStakedBalance(): float
    {
        return $this->coldStakedBalance;
    }

    public function getColdStaked(): float
    {
        return $this->coldStaked;
    }

    public function getColdStakedCount(): int
    {
        return $this->coldStakedCount;
    }

    public function getColdStakedSent()
    {
        return $this->coldStakedSent;
    }

    public function getLabel(): string
    {
        return $this->label ?: "";
    }
}
