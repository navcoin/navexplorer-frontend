<?php

namespace App\Navcoin\Block\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class BlockGroups extends IteratorEntity implements IteratorEntityInterface
{
    /**
     * @var string
     */
    private $period;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [BlockGroup::class];
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function setPeriod(string $period)
    {
        $this->period = $period;

        return $this;
    }

}
