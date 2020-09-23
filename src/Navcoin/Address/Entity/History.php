<?php

namespace App\Navcoin\Address\Entity;

use DateTime;

class History
{
    /** @var int */
    protected $height;

    /** @var int */
    protected $txIndex;

    /** @var DateTime */
    private $time;

    /** @var string */
    private $txId;

    /** @var string */
    private $hash;

    /** @var Changes */
    private $changes;

    /** @var Balance */
    private $balance;

    /** @var bool */
    private $stake;

    /** @var bool */
    private $cfundPayout;

    /** @var bool */
    private $stakePayout;

    public function __construct(
        int $height,
        int $txIndex,
        DateTime $time,
        string $txId,
        string $hash,
        Changes $changes,
        Balance $balance,
        bool $stake,
        bool $cfundPayout,
        bool $stakePayout
    ) {
        $this->height = $height;
        $this->txIndex = $txIndex;
        $this->time = $time;
        $this->txId = $txId;
        $this->hash = $hash;
        $this->changes = $changes;
        $this->balance = $balance;
        $this->stake = $stake;
        $this->cfundPayout = $cfundPayout;
        $this->stakePayout = $stakePayout;
    }


    public function getHeight(): int
    {
        return $this->height;
    }

    public function getTxIndex(): int
    {
        return $this->txIndex;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function getTxId(): string
    {
        return $this->txId;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getChanges(): Changes
    {
        return $this->changes;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }

    public function isStake(): bool
    {
        return $this->stake;
    }

    public function isCfundPayout(): bool
    {
        return $this->cfundPayout;
    }

    public function isStakePayout(): bool
    {
        return $this->stakePayout;
    }
}