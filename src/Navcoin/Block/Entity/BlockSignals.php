<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class BlockSignals
 *
 * @package App\Navcoin\Block\Entity
 */
class BlockSignals extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [BlockSignal::class];
    }
}
