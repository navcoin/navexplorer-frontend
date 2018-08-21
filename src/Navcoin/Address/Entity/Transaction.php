<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Address\Type\AddressTransactionType;

/**
 * Class Transaction
 *
 * @package App\Navcoin\Address\Entity
 */
class Transaction
{
    /**
     * @var String
     */
    private $id;

    /**
     * @var String
     */
    private $transaction;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @var int
     */
    private $height;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var float
     */
    private $sent;

    /**
     * @var float
     */
    private $received;

    /**
     * @var String
     */
    private $type;

    public function __construct(
        String $id,
        String $transaction,
        int $time,
        int $height,
        float $balance,
        float $sent,
        float $received,
        String $type
    ) {
        $this->id = $id;
        $this->transaction = $transaction;
        $date = new \DateTime();
        $this->time = $date->setTimestamp($time);
        $this->height = $height;
        $this->balance = $balance;
        $this->sent = $sent;
        $this->received = $received;
        $this->amount = $this->received - $this->sent;
        $this->type = $type;
    }

    public function getId(): String
    {
        return $this->id;
    }

    public function getTransaction(): string
    {
        return $this->transaction;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getSent(): float
    {
        return $this->sent;
    }

    public function getReceived(): float
    {
        return $this->received;
    }

    public function isStaking(): bool
    {
        return $this->type == AddressTransactionType::STAKING;
    }

    public function getType(): String
    {
        return $this->getType();
    }
}
