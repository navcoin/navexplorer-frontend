<?php

namespace App\Navcoin\Block\Entity;

/**
 * Class Block
 *
 * @package App\Entity
 */
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
     * Constructor
     *
     * @param String    $id
     * @param String    $hash
     * @param String    $merkleRoot
     * @param String    $bits
     * @param int       $size
     * @param int       $version
     * @param int       $nonce
     * @param int       $height
     * @param float     $difficulty
     * @param int       $confirmations
     * @param \DateTime $created
     * @param float     $stake
     * @param float     $fees
     * @param float     $spend
     * @param String    $stakedBy
     * @param int       $transactions
     * @param bool      $best
     * @param BlockSignals $signals
     */
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
        String $stakedBy = '',
        int $transactions = 0,
        bool $best,
        BlockSignals $signals,
        int $blockCycle
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
        $this->stakedBy = $stakedBy;
        $this->transactions = $transactions;
        $this->best = $best;
        $this->signals = $signals;
        $this->blockCycle = $blockCycle;
    }

    /**
     * Get Id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get Hash
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Get MerkleRoot
     *
     * @return string
     */
    public function getMerkleRoot(): string
    {
        return $this->merkleRoot;
    }

    /**
     * Get Bits
     *
     * @return string
     */
    public function getBits(): string
    {
        return $this->bits;
    }

    /**
     * Get Size
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Get Version
     *
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Get Nonce
     *
     * @return int
     */
    public function getNonce(): int
    {
        return $this->nonce;
    }

    /**
     * Get Height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Get Difficulty
     *
     * @return float
     */
    public function getDifficulty(): float
    {
        return $this->difficulty;
    }

    /**
     * Get Confirmations
     *
     * @return int
     */
    public function getConfirmations(): int
    {
        return $this->confirmations;
    }

    /**
     * Get Created
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Get Age
     *
     * @return string
     */
    public function getAge(): string
    {
        return $this->created->diff(new \DateTime())->format("%d days, %h hours and %i minuts");
    }

    /**
     * Get Stake
     *
     * @return float
     */
    public function getStake(): float
    {
        return $this->stake;
    }

    /**
     * Get Fees
     *
     * @return float
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Get Spend
     *
     * @return float
     */
    public function getSpend()
    {
        return $this->spend;
    }

    /**
     * Get StakedBy
     *
     * @return string
     */
    public function getStakedBy(): string
    {
        return $this->stakedBy;
    }

    /**
     * Get Transactions
     *
     * @return int
     */
    public function getTransactions(): int
    {
        return $this->transactions;
    }

    /**
     * Get Best
     *
     * @return bool
     */
    public function isBest(): bool
    {
        return $this->best;
    }

    /**
     * Get Signals
     *
     * @return BlockSignals
     */
    public function getSignals()
    {
        return $this->signals;
    }

    /**
     * Get BlockCycle
     *
     * @return int
     */
    public function getBlockCycle()
    {
        return $this->blockCycle;
    }
}
