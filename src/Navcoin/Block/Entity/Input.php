<?php

namespace App\Navcoin\Block\Entity;

class Input
{
    /**
     * @var string[]
     */
    private $addresses;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $index;

    /**
     * @var string
     */
    private $previousOutput;

    /**
     * @var int
     */
    private $previousOutputBlock;

    public function __construct(array $addresses, ?float $amount, ?int $index, ?string $previousOutput, ?int $previousOutputBlock)
    {
        $this->addresses = $addresses;
        $this->amount = $amount;
        $this->index = $index;
        $this->previousOutput = $previousOutput;
        $this->previousOutputBlock = $previousOutputBlock;
    }

    /**
     * Get Address
     *
     * @return string
     */
    public function getAddress(): string
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
     * Get Index
     *
     * @return int
     */
    public function getIndex(): ?int
    {
        return $this->index;
    }

    /**
     * Get PreviousOutput
     *
     * @return string
     */
    public function getPreviousOutput(): ?string
    {
        return $this->previousOutput;
    }

    /**
     * Get PreviousOutputBlock
     *
     * @return int
     */
    public function getPreviousOutputBlock()
    {
        return $this->previousOutputBlock;
    }
}
