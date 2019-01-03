<?php

namespace App\Navcoin\Block\Entity;

class Block
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $merkleRoot;

    /**
     * @var string
     */
    private $bits;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $version;

    /**
     * @var int
     */
    private $nonce;

    /**
     * @var int
     */
    private $height;

    /**
     * @var float
     */
    private $difficulty;

    /**
     * @var int
     */
    private $confirmations;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var float
     */
    private $stake;

    /**
     * @var float
     */
    private $fees;

    /**
     * @var float
     */
    private $spend;

    /**
     * @var float
     */
    private $cfundPayout;

    /**
     * @var string
     */
    private $stakedBy;

    /**
     * @var int
     */
    private $transactions;

    /**
     * @var bool
     */
    private $best;

    /**
     * @var BlockSignals
     */
    private $signals;

    /**
     * @var int
     */
    private $blockCycle;

    /**
     * @var string
     */
    private $raw;

    /**
     * @var float
     */
    private $balance;

    public function __construct(
        String $id,
        String $hash,
        String $merkleRoot,
        String $bits,
        int $size,
        int $version,
        int $nonce,
        int $height,
        float $difficulty,
        int $confirmations,
        \DateTime $created,
        float $stake = 0.0,
        float $fees = 0.0,
        float $spend = 0.0,
        float $cfundPayout = 0.0,
        String $stakedBy = '',
        int $transactions = 0,
        bool $best,
        BlockSignals $signals,
        ?int $blockCycle,
        string $raw,
        float $balance
    ) {
        $this->id = $id;
        $this->hash = $hash;
        $this->merkleRoot = $merkleRoot;
        $this->bits = $bits;
        $this->size = $size;
        $this->version = $version;
        $this->nonce = $nonce;
        $this->height = $height;
        $this->difficulty = $difficulty;
        $this->confirmations = $confirmations;
        $this->created = $created;
        $this->stake = $stake;
        $this->fees = $fees;
        $this->spend = $spend;
        $this->cfundPayout = $cfundPayout;
        $this->stakedBy = $stakedBy;
        $this->transactions = $transactions;
        $this->best = $best;
        $this->signals = $signals;
        $this->blockCycle = $blockCycle;
        $this->raw = $raw;
        $this->balance = $balance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getMerkleRoot(): string
    {
        return $this->merkleRoot;
    }

    public function getBits(): string
    {
        return $this->bits;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getNonce(): int
    {
        return $this->nonce;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getDifficulty(): float
    {
        return $this->difficulty;
    }

    public function getConfirmations(): int
    {
        return $this->confirmations;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getAge(): string
    {
        return $this->created->diff(new \DateTime())->format("%d days, %h hours and %i minuts");
    }

    public function getStake(): float
    {
        return $this->stake;
    }

    public function getFees()
    {
        return $this->fees;
    }

    public function getSpend()
    {
        return $this->spend;
    }

    public function getCfundPayout(): float
    {
        return $this->cfundPayout;
    }

    public function getStakedBy(): string
    {
        return $this->stakedBy;
    }

    public function getTransactions(): int
    {
        return $this->transactions;
    }

    public function isBest(): bool
    {
        return $this->best;
    }

    public function getSignals()
    {
        return $this->signals;
    }

    public function getBlockCycle()
    {
        return $this->blockCycle;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
