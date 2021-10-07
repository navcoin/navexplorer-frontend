<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Voters;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use GuzzleHttp\Exception\ClientException;
use http\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class VotersApi extends NavcoinApi
{
    public function getProposalVotes(string $hash): Voters
    {
        try {
            $response = $this->getClient()->get("/dao/cfund/proposal/{$hash}/votes");
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Voters::class, $data, null);
    }

    public function getPaymentRequestVotes(string $hash): Voters
    {
        try {
            $response = $this->getClient()->get("/dao/cfund/payment-request/{$hash}/votes");
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundPaymentRequestNotFound(sprintf("The `%s` payment request does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Voters::class, $data, null);
    }

    public function getExcludedVotes(int $cycle): int
    {
        $response = $this->getClient()->get("/dao/cfund/votes/excluded?cycle=".$cycle);

        return intval($this->getClient()->getBody($response));
    }
}