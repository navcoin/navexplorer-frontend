<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Voters;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class VotersApi extends NavcoinApi
{
    public function getProposalVotes(String $hash, bool $vote): Voters
    {
        try {
            $voteString = $vote ? 'true' : 'false';
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$hash.'/voting/'.$voteString);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapIterator($data, Voters::class, ['vote' => $vote]);
    }
}
