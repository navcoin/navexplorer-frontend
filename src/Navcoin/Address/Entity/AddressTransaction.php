<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Address\Type\AddressTransactionType;
use DateTime;

class AddressTransaction
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    private $transaction;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $index;

    /**
     * @var DateTime
     */
    private $time;

    /**
     * @var string
     */
    private $type;

    /**
     * @var boolean
     */
    private $cold;

    /**
     * @var float
     */
    private $input;

    /**
     * @var float
     */
    private $output;

    /**
     * @var float
     */
    private $total;

    /**
     * @var float
     */
    private $balance;

    public function __construct(string $address, string $transaction, int $height, int $index, DateTime $time, string $type, bool $cold, float $input, float $output, float $total, float $balance)
    {
        $this->address = $address;
        $this->transaction = $transaction;
        $this->height = $height;
        $this->index = $index;
        $this->time = $time;
        $this->type = $type;
        $this->cold = $cold;
        $this->input = $input;
        $this->output = $output;
        $this->total = $total;
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTransaction(): string
    {
        return $this->transaction;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return DateTime
     */
    public function getTime(): DateTime
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isCold(): bool
    {
        return $this->cold;
    }

    /**
     * @return float
     */
    public function getInput(): float
    {
        return $this->input;
    }

    /**
     * @return float
     */
    public function getOutput(): float
    {
        return $this->output;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }
}
