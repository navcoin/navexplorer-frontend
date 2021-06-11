<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class Vins extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [Vin::class];
    }

    public function getValue(): float
    {
        return array_reduce($this->getElements(), function($value, $input) {
            /** @var Vin $input */
            return $value += $input->getValue();
        }, 0);
    }

    public function getBalanceForAddress($address): float
    {
        return array_reduce($this->getElements(), function($value, $input) use ($address) {
            /** @var Vin $input */
            return $value -= ($input->getAddress() === $address) ? $input->getAmount() : 0;
        }, 0);
    }

    public function getAddresses() {
        $addresses = [];

        /** @var Vin $input */
        foreach ($this->getElements() as $input) {
            $addresses = array_merge($addresses, $input->getAddresses());
        }

        return $addresses;
    }

    public function hasMultiSig() {
        /** @var Vin $input */
        foreach ($this->getElements() as $input) {
            if ($input->isMultiSig()) {
                return true;
            }
        }
        return false;
    }
}
