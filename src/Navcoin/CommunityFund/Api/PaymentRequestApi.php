<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\PaymentRequests;
use App\Navcoin\CommunityFund\Entity\Proposal;

class PaymentRequestApi extends NavcoinApi
{
    public function getAll(Proposal $proposal): PaymentRequests
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$proposal->getHash().'/payment-request');
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator($data, PaymentRequests::class);
    }

    public function getPaymentRequestsForProposalByState(Proposal $proposal, string $state, string $order = 'id'): PaymentRequests
    {
        $state = strtoupper($state);

        try {
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$proposal->getHash().'/payment-request/state/'.$state.'?order='.$order);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator($data, PaymentRequests::class);
    }
}
