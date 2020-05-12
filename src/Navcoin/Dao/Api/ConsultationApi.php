<?php

namespace App\Navcoin\Dao\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use App\Navcoin\Dao\Entity\Consultation;
use App\Navcoin\Dao\Entity\Consultations;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class ConsultationApi extends NavcoinApi
{
    public function getByHash(string $hash): Consultation
    {
        try {
            $response = $this->getClient()->get('/dao/consultation/'.$hash);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` consultation does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getByState(int $state): Consultations
    {
        try {
            $response = $this->getClient()->get('/dao/consultation?size=5000&state='.$state);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Consultations();
        }

        return $this->getMapper()->mapIterator(Consultations::class, $data);
    }

    public function getAllConsensus(): Consultations
    {
        try {
            $response = $this->getClient()->get('/dao/consensus/consultations');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Consultations();
        }

        return $this->getMapper()->mapIterator(Consultations::class, $data);
    }
}