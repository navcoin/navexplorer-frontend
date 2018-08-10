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
    private $addresses;

    /**
     * @var string
     */
    private $redeemedInTransaction;

    /**
     * @var int
     */
    private $redeemedInBlock;

    /**
     * @var string
     */
    private $type;

    public function __construct(int $index, float $amount, ?array $addresses, ?string $redeemedInTransaction, ?int $redeemedInBlock, ?string $type)
    {
        $this->index = $index;
        $this->amount = $amount;
        $this->addresses = $addresses;
        $this->redeemedInTransaction = $redeemedInTransaction;
        $this->redeemedInBlock = $redeemedInBlock;
        $this->type = $type;
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
    public function getAddresses()
    {
        return $this->addresses;
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

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
