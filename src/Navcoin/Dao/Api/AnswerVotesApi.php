<?php

namespace App\Navcoin\Dao\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Voters;
use App\Navcoin\CommunityFund\Exception\CommunityFundPaymentRequestNotFound;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use App\Navcoin\Dao\Exception\AnswerNotFound;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class AnswerVotesApi extends NavcoinApi
{
    public function getAnswerVotes(String $hash, String $answer): Voters
    {
        try {
            $response = $this->getClient()->get("/dao/consultation/{$hash}/{$answer}/votes");
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new AnswerNotFound(sprintf("The `%s` answer does not exist.", $answer), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator(Voters::class, $data, null);
    }
}
