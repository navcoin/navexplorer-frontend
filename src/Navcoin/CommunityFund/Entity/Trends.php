<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class Trends extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [Trend::class];
    }
}
