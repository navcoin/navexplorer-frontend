<?php

namespace App\Navcoin\Address\Entity;

/**
 * Class Address
 *
 * @package App\Navcoin\Address\Entity
 */
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
     * Constructor
     *
     * @param string $hash
     * @param float  $received
     * @param int    $receivedCount
     * @param float  $sent
     * @param int    $sentCount
     * @param float  $staked
     * @param int    $stakedCount
     * @param float  $stakeSent
     * @param float  $balance
     * @param int    $blockIndex
     * @param int    $richListPosition
     */
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
        $this->label = $label;
    }

    /**
     * Get Hash
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Get Received
     *
     * @return float
     */
    public function getReceived(): float
    {
        return $this->received;
    }

    /**
     * Get ReceivedCount
     *
     * @return int
     */
    public function getReceivedCount(): int
    {
        return $this->receivedCount;
    }

    /**
     * Get Sent
     *
     * @return float
     */
    public function getSent(): float
    {
        return $this->sent;
    }

    /**
     * Get SentCount
     *
     * @return int
     */
    public function getSentCount(): int
    {
        return $this->sentCount;
    }

    /**
     * Get Staked
     *
     * @return float
     */
    public function getStaked(): float
    {
        return $this->staked;
    }

    /**
     * Get StakedCount
     *
     * @return int
     */
    public function getStakedCount(): int
    {
        return $this->stakedCount;
    }

    /**
     * Get StakedSent
     *
     * @return float
     */
    public function getStakedSent(): float
    {
        return $this->stakedSent;
    }

    /**
     * Get Balance
     *
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Get BlockIndex
     *
     * @return int
     */
    public function getBlockIndex(): int
    {
        return $this->blockIndex;
    }

    /**
     * Get RichListPosition
     *
     * @return int
     */
    public function getRichListPosition(): int
    {
        return $this->richListPosition;
    }

    /**
     * Get Transactions
     *
     * @return int
     */
    public function getTransactions(): int
    {
        return $this->sentCount + $this->receivedCount + $this->stakedCount;
    }

    public function getLabel(): string
    {
        return $this->getLabel() ?: "";
    }
}
