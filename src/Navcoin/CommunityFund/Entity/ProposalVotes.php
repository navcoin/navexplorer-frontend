<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

class ProposalVotes extends IteratorEntity implements IteratorEntityInterface
{
    public function setSupportedTypes()
    {
        $this->supportedTypes = [ProposalVote::class];
    }

    public function getLatestVotes(): ?ProposalVote
    {
        if (count($this->getElements()) == 0) {
            return null;
        }

        return $this->getElements()[count($this->getElements()) -1];
    }
}
