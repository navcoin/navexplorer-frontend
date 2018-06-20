<?php

namespace App\Navcoin\Block\Entity;

/**
 * Class Output
 *
 * @package App\Navcoin\Block\Entity
 */
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
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $redeemedInTransaction;

    /**
     * @var int
     */
    private $redeemedInBlock;

    /**
     * Constructor
     *
     * @param int    $index
     * @param float  $amount
     * @param string $address
     * @param string $redeemedInTransaction
     * @param int    $redeemedInBlock
     */
    public function __construct(int $index, float $amount, ?string $address, ?string $redeemedInTransaction, ?int $redeemedInBlock)
    {
        $this->index = $index;
        $this->amount = $amount;
        $this->address = $address;
        $this->redeemedInTransaction = $redeemedInTransaction;
        $this->redeemedInBlock = $redeemedInBlock;
    }

    /**
     * Get Index
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get Amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get Address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get RedeemedInTransaction
     *
     * @return string
     */
    public function getRedeemedInTransaction()
    {
        return $this->redeemedInTransaction;
    }

    /**
     * Get RedeemedInBlock
     *
     * @return int
     */
    public function getRedeemedInBlock()
    {
        return $this->redeemedInBlock;
    }
}
