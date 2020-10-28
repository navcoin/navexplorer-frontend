<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;
use App\Navcoin\SoftFork\Entity\SoftFork;

class Voters extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [Voter::class];
    }

    public function latestCycle(): Voter {
        return $this->getElements()[count($this->getElements())-1];
    }
}
