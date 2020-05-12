<?php

namespace App\Navcoin\Dao\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Dao\Entity\ConsensusParameters;
use GuzzleHttp\Exception\ClientException;

class ConsensusApi extends NavcoinApi
{
    public function getConsensusParameters(): ConsensusParameters
    {
        try {
            $response = $this->getClient()->get('/dao/consensus/parameters');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw $e;
        }

        return $this->getMapper()->mapEntity($data);
    }
}