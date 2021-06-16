<?php

namespace App\Navcoin\Block\Entity;

class Transaction
{
    /** @var String */
    private $hash;

    /** @var int */
    private $height;

    /** @var \DateTime */
    private $time;

    /** @var float */
    private $stake;

    /** @var float */
    private $fees;

    /** @var string */
    private $type;

    /** @var Vins */
    private $vins;

    /** @var Vouts */
    private $vouts;

    /** @var string */
    private $raw;

    /** @var int */
    private $size;

    /** @var int */
    private $version;

    /** @var ProposalVotes*/
    private $proposalVotes;

    /** @var bool*/
    private $private;

    /** @var bool */
    private $wrapped;

    /** @var bool */
    private $script;

    public function __construct(
        String $hash,
        int $height,
        \DateTime $time,
        float $stake,
        float $fees,
        Vins $vins,
        Vouts $vouts,
        string $type,
        string $raw,
        string $size,
        string $version,
        bool $private,
        bool $wrapped,
        bool $script
    ) {
        $this->hash = $hash;
        $this->height = $height;
        $this->time = $time;
        $this->stake = $stake;
        $this->fees = $fees;
        $this->vins = $vins;
        $this->vouts = $vouts;
        $this->type = $type;
        $this->raw = $raw;
        $this->size = $size;
        $this->version = $version;
        $this->private = $private;
        $this->wrapped = $wrapped;
        $this->script = $script;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function getStake(): float
    {
        return $this->stake;
    }

    public function isStaking(): bool
    {
        return $this->stake ? true : false;
    }

    public function getFees(): float
    {
        return $this->fees;
    }

    public function hasFees(): bool
    {
        return $this->fees ? true : false;
    }

    public function getVins(): Vins
    {
        return $this->vins;
    }

    public function getInputElements(): array
    {
        return $this->vins->getElements();
    }

    public function getVouts(): Vouts
    {
        return $this->vouts;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOutputElements(): array
    {
        return $this->vouts->getElements();
    }

    public function getSpendForAddress(String $address): float
    {
        return (float) $this->vouts->getBalanceForAddress($address) + $this->vins->getBalanceForAddress($address);
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getProposalVotes(): ?ProposalVotes
    {
        return $this->proposalVotes;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function isWrapped(): bool
    {
        return $this->wrapped;
    }

    public function isCoinbase(): bool
    {
        return $this->type == "coinbase";
    }

    public function isScript(): bool
    {
        return $this->script;
    }
}
