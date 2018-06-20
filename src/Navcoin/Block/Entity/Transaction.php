<?php

namespace App\Navcoin\Block\Entity;

use JMS\Serializer\Annotation\Accessor;

/**
 * Class Transaction
 *
 * @package App\Navcoin\Block\Entity
 */
class Transaction
{
    /**
     * @var String
     */
    private $id;

    /**
     * @var String
     */
    private $hash;

    /**
     * @var int
     */
    private $height;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @var float
     */
    private $stake;

    /**
     * @var float
     */
    private $fees;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Inputs
     *
     * @Accessor(getter="getInputElements")
     */
    private $inputs;

    /**
     * @var Outputs
     *
     * @Accessor(getter="getOutputElements")
     */
    private $outputs;

    /**
     * Constructor
     *
     * @param String    $id
     * @param String    $hash
     * @param int       $height
     * @param \DateTime $time
     * @param float     $stake
     * @param float     $fees
     * @param Inputs    $inputs
     * @param Outputs   $outputs
     * @param string    $type
     */
    public function __construct(
        String $id,
        String $hash,
        int $height,
        \DateTime $time,
        float $stake,
        float $fees,
        Inputs $inputs,
        Outputs $outputs,
        string $type
    ) {
        $this->id = $id;
        $this->hash = $hash;
        $this->height = $height;
        $this->time = $time;
        $this->stake = $stake;
        $this->fees = $fees;
        $this->inputs = $inputs;
        $this->outputs = $outputs;
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
     * Get Height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Get Time
     *
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
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
     * Is Staking?
     *
     * @return bool
     */
    public function isStaking(): bool
    {
        return $this->stake ? true : false;
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
     * Has Fees?
     *
     * @return bool
     */
    public function hasFees(): bool
    {
        return $this->fees ? true : false;
    }

    /**
     * Get Inputs
     *
     * @return Inputs
     */
    public function getInputs(): Inputs
    {
        return $this->inputs;
    }

    /**
     * Get Inputs
     *
     * @return Input[]
     */
    public function getInputElements(): array
    {
        return $this->inputs->getElements();
    }

    /**
     * Get Outputs
     *
     * @return Outputs
     */
    public function getOutputs(): Outputs
    {
        return $this->outputs;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get Outputs
     *
     * @return Output[]
     */
    public function getOutputElements(): array
    {
        return $this->outputs->getElements();
    }

    /**
     * Get Spend for address
     *
     * @param String $address
     *
     * @return float
     */
    public function getSpendForAddress(String $address): float
    {
        return (float) $this->outputs->getBalanceForAddress($address) + $this->inputs->getBalanceForAddress($address);
    }
}
