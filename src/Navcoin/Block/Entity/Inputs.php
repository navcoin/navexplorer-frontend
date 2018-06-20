<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class Inputs
 *
 * @package App\Navcoin\Block\Entity
 */
class Inputs extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Input::class];
    }

    /**
     * Get Value
     *
     * @return float
     */
    public function getValue() {
        return array_reduce($this->getElements(), function($value, $input) {
            /** @var Input $input */
            return $value += $input->getAmount();
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
        return array_reduce($this->getElements(), function($value, $input) use ($address) {
            /** @var Input $input */
            return $value -= ($input->getAddress() === $address) ? $input->getAmount() : 0;
        }, 0);
    }
}
