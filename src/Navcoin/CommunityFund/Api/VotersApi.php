<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Voters;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class VotersApi extends NavcoinApi
{
    public function getProposalVotes(String $hash, bool $vote): Voters
    {
        try {
            $voteString = $vote ? 'true' : 'false';
            $response = $this->getClient()->get('/api/community-fund/proposal/' . $hash . '/vote/' . $voteString);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Voters::class, $data, null, ['vote' => $vote]);
    }

    public function getPaymentRequestVotes(String $hash, bool $vote): Voters
    {
        try {
            $voteString = $vote ? 'true' : 'false';
            $response = $this->getClient()->get('/api/community-fund/payment-request/' . $hash . '/vote/' . $voteString);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundPaymentRequestNotFound(sprintf("The `%s` payment request does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Voters::class, $data, null, ['vote' => $vote]);
    }
}