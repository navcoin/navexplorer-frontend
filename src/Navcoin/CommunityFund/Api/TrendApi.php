<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Trends;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class TrendApi extends NavcoinApi
{
    public function getProposalVotingTrend(String $hash): Trends
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/proposal/' . $hash . '/trend');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Trends::class, $data);
    }

    public function getPaymentRequestVotingTrend(String $hash): Trends
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/payment-request/' . $hash . '/trend');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundPaymentRequestNotFound(sprintf("The `%s` payment request does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Trends::class, $data);
    }
}
