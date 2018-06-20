<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class Transactions
 *
 * @package App\Navcoin\Block\Entity
 */
class Transactions extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Transaction::class];
    }
}
