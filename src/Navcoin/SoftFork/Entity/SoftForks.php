<?php

namespace App\Navcoin\SoftFork\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class SoftForks
 *
 * @package App\Navcoin\SoftFork\Entity
 */
class SoftForks extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [SoftFork::class];
    }
}

