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

    /**
     * Constructor
     *
     * @param String $id
     * @param String $transaction
     * @param int    $time
     * @param int    $height
     * @param float  $balance
     * @param float  $sent
     * @param float  $received
     * @param float  $amount
     * @param string $type
     */
    public function __construct(
        String $id,
        String $transaction,
        int $time,
        int $height,
        float $balance,
        float $sent,
        float $received,
        float $amount,
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
        $this->amount = $amount;
        $this->type = $type;
    }

    /**
     * Get Id
     *
     * @return string
     */
    public function getId(): String
    {
        return $this->id;
    }

    /**
     * Get Transaction
     *
     * @return string
     */
    public function getTransaction(): string
    {
        return $this->transaction;
    }

    /**
     * Get Time
     *
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * Get Height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
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
     * Get Amount
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
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
     * Get Received
     *
     * @return float
     */
    public function getReceived(): float
    {
        return $this->received;
    }

    /**
     * Get Staking
     *
     * @return bool
     */
    public function isStaking(): bool
    {
        return $this->type == AddressTransactionType::STAKING;
    }

    /**
     * Get Type
     *
     * @return String
     */
    public function getType(): String
    {
        return $this->getType();
    }
}
