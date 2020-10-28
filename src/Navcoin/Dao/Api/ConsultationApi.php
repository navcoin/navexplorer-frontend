<?php

namespace App\Navcoin\Dao\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\Proposals;
use App\Navcoin\Dao\Entity\Answer;
use App\Navcoin\Dao\Entity\Consultation;
use App\Navcoin\Dao\Entity\Consultations;
use App\Navcoin\Dao\Exception\AnswerNotFound;
use App\Navcoin\Dao\Exception\ConsultationNotFound;
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
                    throw new ConsultationNotFound(sprintf("The `%s` consultation does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }
    public function getByAnswerHash(string $hash): Answer
    {
        try {
            $response = $this->getClient()->get('/dao/answer/'.$hash);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new AnswerNotFound(sprintf("The `%s` answer does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapAnswer($data);
    }

    public function getConsultations(array $parameters, int $size = 10, int $page = 1, $paginate = false): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get('/dao/consultation?size='.$size.'&page='.$page.'&'.http_build_query($parameters));
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Consultations();
        }

        $paginator = $paginate ? $this->getClient()->getPaginator($response) : null;
        return $this->getMapper()->mapIterator(Consultations::class, $data, $paginator);
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