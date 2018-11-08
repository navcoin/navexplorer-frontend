<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class Outputs extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Output::class];
    }

    public function getValue(): float
    {
        return array_reduce($this->getElements(), function($value, $output) {
            /** @var Output $output */
            return $value += $output->getAmount();
        }, 0);
    }

    public function getBalanceForAddress(string $address): float
    {
        return array_reduce($this->getElements(), function($value, $output) use ($address) {
            /** @var Output $output */
            return $value += ($output->getAddress() === $address) ? $output->getAmount() : 0;
        }, 0);
    }

    public function getAddresses(): array
    {
        $addresses = [];

        /** @var Input $input */
        foreach ($this->getElements() as $input) {
            $addresses = array_merge($addresses, $input->getAddresses());
        }

        return $addresses;
    }
}
