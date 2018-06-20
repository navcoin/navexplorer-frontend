<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class Outputs
 *
 * @package App\Navcoin\Block\Entity
 */
class Outputs extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Output::class];
    }

    /**
     * Get Value
     *
     * @return float
     */
    public function getValue() {
        return array_reduce($this->getElements(), function($value, $output) {
            /** @var Output $output */
            return $value += $output->getAmount();
        }, 0);
    }

    /**
     * Get Balance For Address
     *
     * @param string $address
     *
     * @return float
     */
    public function getBalanceForAddress($address) {
        return array_reduce($this->getElements(), function($value, $output) use ($address) {
            /** @var Output $output */
            return $value += ($output->getAddress() === $address) ? $output->getAmount() : 0;
        }, 0);
    }
}
