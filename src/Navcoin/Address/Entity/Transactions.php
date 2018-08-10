<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class Transactions
 *
 * @package App\Navcoin\Address\Entity
 */
class Transactions extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [AddressTransaction::class];
    }
}
