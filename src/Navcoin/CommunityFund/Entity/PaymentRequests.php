<?php

namespace App\Navcoin\CommunityFund\Entity;

use App\Navcoin\Common\Entity\IteratorEntity;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginated;

class PaymentRequests extends IteratorEntity implements IteratorEntityInterface
{
    use Paginated;

    public function setSupportedTypes()
    {
        $this->supportedTypes = [PaymentRequest::class];
    }

    public function sortByVotes() {
        $paymentRequests = $this->getElements();
        usort($paymentRequests, function (PaymentRequest $a, PaymentRequest $b) {
            return -1 * ($a->getVotesTotal() - $b->getVotesTotal());
        });

        $this->setElements($paymentRequests);
    }

    public function limit(int $limit) {
        $this->setElements(array_slice($this->getElements(), 0, $limit));
    }
}
