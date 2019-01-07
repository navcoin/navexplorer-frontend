<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Address\Type\AddressTransactionType;

class AddressTransaction
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
    private $coldStakingBalance;

    /**
     * @var float
     */
    private $coldStakingAmount;

    /**
     * @var float
     */
    private $coldStakingSent;

    /**
     * @var float
     */
    private $coldStakingReceived;

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
        float $coldStakingBalance,
        float $coldStakingSent,
        float $coldStakingReceived
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
        $this->address = $address;
        $this->coldStakingBalance = $coldStakingBalance;
        $this->coldStakingSent = $coldStakingSent;
        $this->coldStakingReceived = $coldStakingReceived;
        $this->coldStakingAmount = $this->coldStakingReceived - ($this->type !== 'RECEIVE' ? $this->coldStakingSent : 0);
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

    public function getColdStakingBalance(): float
    {
        return $this->coldStakingBalance;
    }

    public function getColdStakingAmount(): float
    {
        return $this->coldStakingAmount;
    }

    public function getColdStakingSent(): float
    {
        return $this->coldStakingSent;
    }

    public function getColdStakingReceived(): float
    {
        return $this->coldStakingReceived;
    }
}
