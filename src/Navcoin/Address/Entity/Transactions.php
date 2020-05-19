<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class Transactions extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [AddressTransaction::class];
    }
}
