<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\PaymentRequests;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use Symfony\Component\HttpFoundation\Response;

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

    public function getPaymentRequest(String $hash): PaymentRequest
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/payment-request/'.$hash);
        } catch (ServerRequestException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundPaymentRequestNotFound(sprintf("The `%s` payment request does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getPaymentRequests(Proposal $proposal): PaymentRequests
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$proposal->getHash().'/payment-request');
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator($data, PaymentRequests::class);
    }

    public function getPaymentRequestsByState(string $state, $order = 'id'): PaymentRequests
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/payment-request/state/'.$state.'?order='.$order);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        $paymentRequests = $this->getMapper()->mapIterator($data, PaymentRequests::class);

        if ($order == 'votes') {
            $paymentRequests->sortByVotes();
        }

        return $paymentRequests;
    }

    public function getPaymentRequestsForProposalByState(Proposal $proposal, string $state): PaymentRequests
    {
        $state = strtoupper($state);

        try {
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$proposal->getHash().'/payment-request/state/' . $state);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator($data, PaymentRequests::class);
    }
}
