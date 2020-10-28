<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class PaymentRequestVotes extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [PaymentRequestVote::class];
    }

    public function getLatestVotes(): ?PaymentRequestVote
    {
        if (count($this->getElements()) == 0) {
            return null;
        }

        return $this->getElements()[count($this->getElements()) -1];
    }

    public function getVotingCycle(int $votingCycle): ?PaymentRequestVote
    {
        /** @var PaymentRequestVote $element */
        foreach ($this->getElements() as $element) {
            if ($element->getVotingCycle() == $votingCycle) {
                return $element;
            }
        }
    }
}
