<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class Proposals extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [Proposal::class];
    }

    public function sortByVotes() {
        $proposals = $this->getElements();
//        usort($proposals, function (Proposal $a, Proposal $b) {
//            return -1 * ($a->getVotesTotal() - $b->getVotesTotal());
//        });

        $this->setElements($proposals);
    }

    public function limit(int $limit) {
        $this->setElements(array_slice($this->getElements(), 0, $limit));
    }
}

