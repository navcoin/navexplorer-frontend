<?php

namespace App\Navcoin\Block\Entity;

class Input
{
    /** @var string[] */
    private $addresses;

    /** @var float */
    private $amount;

    /** @var int */
    private $index;

    /** @var string */
    private $previousOutput;

    /** @var int */
    private $previousOutputIndex;

    /** @var int */
    private $previousOutputHeight;

    /** @var bool */
    private $private;

    /** @var bool */
    private $wrapped;

    /** @var string[] */
    private $wrappedAddresses;

    public function __construct(array $addresses,
                                ?float $amount,
                                ?int $index,
                                ?string $previousOutput,
                                ?int $previousOutputIndex,
                                ?int $previousOutputHeight,
                                ?bool $private,
                                ?bool $wrapped) {
        $this->addresses = $addresses;
        $this->amount = $amount;
        $this->index = $index;
        $this->previousOutput = $previousOutput;
        $this->previousOutputIndex = $previousOutputIndex;
        $this->previousOutputHeight = $previousOutputHeight;
        $this->private = $private;
        $this->wrapped = $wrapped;
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

    public function getPreviousOutputIndex(): ?int
    {
        return $this->previousOutputIndex;
    }

    public function getPreviousOutputHeight(): int
    {
        return $this->previousOutputHeight;
    }

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function isWrapped(): bool
    {
        return $this->wrapped;
    }

    public function getWrappedAddresses(): ?array
    {
        return $this->wrappedAddresses;
    }

    public function setWrappedAddresses(array $wrappedAddresses): void
    {
        $this->wrappedAddresses = $wrappedAddresses;
    }
}
