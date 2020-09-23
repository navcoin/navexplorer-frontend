<?php

namespace App\Navcoin\Address\Api;

use App\Exception\AddressInvalidException;
use App\Exception\AddressNotFoundException;
use App\Navcoin\Address\Entity\Summary;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class SummaryApi extends NavcoinApi
{
    public function getSummary(String $hash): Summary
    {
        try {
            $response = $this->getClient()->get('/address/' . $hash . '/summary');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new AddressNotFoundException(sprintf("The `%s` address does not exist.", $hash), 0, $e);
                case Response::HTTP_BAD_REQUEST:
                    throw new AddressInvalidException(sprintf("The `%s` address is invalid.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }
}