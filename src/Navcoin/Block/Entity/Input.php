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

    public function __construct(?array $addresses, ?float $amount, ?int $index, ?string $previousOutput, ?int $previousOutputBlock)
    {
        $this->addresses = $addresses;
        $this->amount = $amount;
        $this->index = $index;
        $this->previousOutput = $previousOutput;
        $this->previousOutputBlock = $previousOutputBlock;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function getPreviousOutput(): ?string
    {
        return $this->previousOutput;
    }

    public function getPreviousOutputBlock()
    {
        return $this->previousOutputBlock;
    }
}
