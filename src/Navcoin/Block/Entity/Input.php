<?php

namespace App\Navcoin\Block\Entity;

/**
 * Class Input
 *
 * @package App\Navcoin\Block\Entity
 */
class Input
{
    /**
     * @var string
     */
    private $address;

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

    /**
     * Constructor
     * @param string $address
     * @param float  $amount
     * @param int    $index
     * @param string $previousOutput
     * @param int $previousOutputBlock
     */
    public function __construct(?string $address, ?float $amount, ?int $index, ?string $previousOutput, ?int $previousOutputBlock)
    {
        $this->address = $address;
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
        return $this->address ?: '';
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
