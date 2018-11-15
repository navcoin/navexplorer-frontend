<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class Inputs extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Input::class];
    }

    public function getValue(): float
    {
        return array_reduce($this->getElements(), function($value, $input) {
            /** @var Input $input */
            return $value += $input->getAmount();
        }, 0);
    }

    public function getBalanceForAddress($address): float
    {
        return array_reduce($this->getElements(), function($value, $input) use ($address) {
            /** @var Input $input */
            return $value -= ($input->getAddress() === $address) ? $input->getAmount() : 0;
        }, 0);
    }

    public function getAddresses() {
        $addresses = [];

        /** @var Input $input */
        foreach ($this->getElements() as $input) {
            $addresses = array_merge($addresses, $input->getAddresses());
        }

        return $addresses;
    }
}
