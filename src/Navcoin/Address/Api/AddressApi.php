<?php

namespace App\Navcoin\Address\Api;

use App\Exception\AddressIndexIncompleteException;
use App\Exception\AddressInvalidException;
use App\Exception\ServerRequestException;
use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class AddressApi extends NavcoinApi
{
    public function getAddress(String $hash): Address
    {
        try {
            $data = $this->getClient()->get('/api/address/'.$hash);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new AddressInvalidException(sprintf("The `%s` address does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getTop100Addresses(): array
    {
        try {
            $data = $this->getClient()->get('/api/address/top/100');
        } catch (ServerRequestException $e) {
            throw new AddressIndexIncompleteException(sprintf("Could not return top 100 addresses"), 0, $e);
        }

        return $this->getMapper()->mapIterator($data);
    }
}
