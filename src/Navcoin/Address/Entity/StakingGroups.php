<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class StakingGroups extends IteratorEntity implements IteratorEntityInterface
{
    /**
     * @var string
     */
    private $period;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [StakingGroup::class];
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

    public function getMaxStakes(): int
    {
        return max(array_map(function($o) {
            /** @var $o StakingGroup */
            return $o->getStakes();
        }, $this->getElements()));
    }

}
