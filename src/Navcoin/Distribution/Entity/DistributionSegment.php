<?php

namespace App\Navcoin\Distribution\Entity;

/**
 * Class DistributionSegment
 *
 * @package App\Navcoin\Distribution\Entity
 */
class DistributionSegment
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var float
     */
    private $total;

    /**
     * @var float
     */
    private $value;

    /**
     * @var int
     */
    private $percentage;

    /**
     * Constructor
     *
     * @param int|null $position
     * @param float    $total
     * @param float    $value
     * @param float    $percentage
     */
    public function __construct(?int $position, float $total, float $value, float $percentage)
    {
        $this->position = $position;
        $this->total = $total;
        $this->value = $value;
        $this->percentage = $percentage;
    }

    /**
     * Get Position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Get Total
     *
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * Get Value
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Get Percentage
     *
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }
}
