<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\PaymentRequests;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class PaymentRequestApi extends NavcoinApi
{
    public function getAll(Proposal $proposal): PaymentRequests
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/proposal/'.$proposal->getHash().'/payment-request');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator(PaymentRequests::class, $data);
    }

    public function getPaymentRequest(String $hash): PaymentRequest
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/payment-request/'.$hash);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
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
            $response = $this->getClient()->get('/dao/cfund/proposal/' . $proposal->getHash() . '/payment-request');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        return $this->getMapper()->mapIterator(PaymentRequests::class, $data);
    }

    public function getByStatus(string $status, $order = 'id'): PaymentRequests
    {
        try {
            $response = $this->getClient()->get("/dao/cfund/payment-request?status={$status}&size=5000");
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new PaymentRequests();
        }

        $paymentRequests = $this->getMapper()->mapIterator(PaymentRequests::class, $data);

        if ($order == 'votes') {
            $paymentRequests->sortByVotes();
        }

        return $paymentRequests;
    }
}
