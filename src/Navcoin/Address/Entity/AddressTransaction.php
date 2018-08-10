<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Address\Type\AddressTransactionType;

class AddressTransaction
{
    /**
     * @var String
     */
    protected $id;

    /**
     * @var String
     */
    protected $transaction;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var float
     */
    protected $balance;

    /**
     * @var float
     */
    protected $sent;

    /**
     * @var float
     */
    protected $received;

    /**
     * @var String
     */
    protected $type;

    /**
     * @var String
     */
    protected $address;

    /**
     * @var bool
     */
    protected $coldStaking;

    /**
     * @var String
     */
    protected $coldStakingAddress;

    /**
     * @var float
     */
    protected $amount;

    public function __construct(
        String $id,
        String $transaction,
        int $time,
        int $height,
        float $balance,
        float $sent,
        float $received,
        String $type,
        String $address,
        bool $coldStaking,
        ?String $coldStakingAddress
    ) {
        $this->id = $id;
        $this->transaction = $transaction;
        $date = new \DateTime();
        $this->time = $date->setTimestamp($time);
        $this->height = $height;
        $this->balance = $balance;
        $this->sent = $sent;
        $this->received = $received;
        $this->type = $type;
        $this->address = $address;
        $this->coldStaking = $coldStaking;
        $this->coldStakingAddress = $coldStakingAddress;

        switch ($this->type) {
            case 'SEND':
            case 'RECEIVE':
                $this->amount = $this->received - $this->sent;
                break;
            case 'STAKING':
                $this->amount = $this->received - $this->sent;
                break;
            case 'COMMUNITY_FUND':
                $this->amount = $this->received;
                break;
            default:
                $this->amount = 0;
        }
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

    public function getAddress(): String
    {
        return $this->address;
    }

    public function isColdStaking(): bool
    {
        return $this->coldStaking;
    }

    public function getColdStakingAddress(): String
    {
        return $this->coldStakingAddress;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
