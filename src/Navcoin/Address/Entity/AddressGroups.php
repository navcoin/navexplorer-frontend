<?php

namespace App\Navcoin\Address\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class AddressGroups extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    /** @var string */
    private $period;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [AddressGroup::class];
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
