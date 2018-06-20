<?php

namespace App\Navcoin\Block\Entity;

/**
 * Class BlockGroup
 *
 * @package App\Navcoin\Block\Entity
 */
class BlockGroup
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var int
     */
    private $secondsInPeriod;

    /**
     * @var int
     */
    private $blocks;

    /**
     * @var int
     */
    private $transactions;

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
     * @var int
     */
    private $height;

    /**
     * Constructor
     * @param string $type
     * @param \DateTime $start
     * @param \DateTime $end
     * @param int       $secondsInPeriod
     * @param int       $blocks
     * @param int       $transactions
     * @param float     $stake
     * @param float     $fees
     * @param float     $spend
     * @param int       $height
     */
    public function __construct(
        string $type,
        \DateTime $start,
        \DateTime $end,
        int $secondsInPeriod,
        int $blocks,
        int $transactions,
        float $stake,
        float $fees,
        float $spend,
        int $height
    ) {
        $this->type = $type;
        $this->start = $start;
        $this->end = $end;
        $this->secondsInPeriod = $secondsInPeriod;
        $this->blocks = $blocks;
        $this->transactions = $transactions;
        $this->stake = $stake;
        $this->fees = $fees;
        $this->spend = $spend;
        $this->height = $height;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Start
     *
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * Get End
     *
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * Get SecondsInPeriod
     *
     * @return int
     */
    public function getSecondsInPeriod(): int
    {
        return $this->secondsInPeriod;
    }

    /**
     * Get Blocks
     *
     * @return int
     */
    public function getBlocks(): int
    {
        return $this->blocks;
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
    public function getFees(): float
    {
        return $this->fees;
    }

    /**
     * Get Spend
     *
     * @return float
     */
    public function getSpend(): float
    {
        return $this->spend;
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
     * @return int
     */
    public function getInterval(): int
    {
        return $this->getSecondsInPeriod() / $this->getTransactions();
    }
}
