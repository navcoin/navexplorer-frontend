<?php

namespace App\Navcoin\Block\Entity;

class Vin
{
    /** @var string */
    private $coinbase;

    /** @var string */
    private $txId;

    /** @var int */
    private $vout;

    /** @var int */
    private $sequence;

    /** @var float */
    private $value = 0;

    /** @var int */
    private $valuesat = 0;

    /** @var PreviousOutput */
    private $previousOutput;

    /** @var string[] */
    private $addresses = [];

    public function __construct(
        ?string $coinbase,
        ?string $txId,
        ?int $vout,
        int $sequence,
        ?float $value,
        ?int $valuesat,
        ?PreviousOutput $previousOutput,
        ?array $addresses
    ){
        if ($coinbase != null) {
            $this->coinbase = $coinbase;
        }
        $this->txId = $txId;
        $this->vout = $vout;
        $this->sequence = $sequence;
        if ($value != null) {
            $this->value = $value;
        }
        if ($valuesat != null) {
            $this->valuesat = $valuesat;
        }
        if ($previousOutput != null) {
            $this->previousOutput = $previousOutput;
        }
        if ($addresses != null) {
            $this->addresses = $addresses;
        }
    }

    public function getCoinbase(): ?string
    {
        return $this->coinbase;
    }

    public function getTxId(): ?string
    {
        return $this->txId;
    }

    public function getVout(): ?int
    {
        return $this->vout;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getValuesat(): int
    {
        return $this->valuesat;
    }

    public function getPreviousOutput(): ?PreviousOutput
    {
        return $this->previousOutput;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function isPrivate(): bool
    {
        return $this->previousOutput != null && $this->previousOutput->isPrivate();
    }

    public function isPrivateFee(): bool
    {
        return $this->previousOutput != null && $this->previousOutput->isPrivate();
    }

    public function isWrapped(): bool
    {
        return $this->previousOutput != null && $this->previousOutput->isWrapped();
    }

    public function isMultiSig(): bool
    {
        return $this->previousOutput != null && $this->previousOutput->isMultiSig();
    }

}
