<?php

namespace App\Navcoin\Block\Entity;

class Output
{
    /**
     * @var int
     */
    private $index;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string[]
     */
    private $addresses = [];

    /**
     * @var string
     */
    private $redeemedInTransaction;

    /**
     * @var int
     */
    private $redeemedInBlock;

    public function __construct(int $index, float $amount, array $addresses, ?string $redeemedInTransaction, ?int $redeemedInBlock)
    {
        $this->index = $index;
        $this->amount = $amount;
        $this->addresses = $addresses;
        $this->redeemedInTransaction = $redeemedInTransaction;
        $this->redeemedInBlock = $redeemedInBlock;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAddress(): ?string
    {
        if (count($this->addresses) == 0) {
            return null;
        }

        return $this->addresses[0];
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getRedeemedInTransaction(): ?string
    {
        return $this->redeemedInTransaction;
    }

    public function getRedeemedInBlock(): ?int
    {
        return $this->redeemedInBlock;
    }
}
