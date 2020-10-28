<?php

namespace App\Navcoin\Address\Api;

use App\Exception\AddressIndexIncompleteException;
use App\Exception\AddressInvalidException;
use App\Exception\AddressNotFoundException;
use App\Exception\ServerRequestException;
use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Address\Entity\Addresses;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class AddressApi extends NavcoinApi
{
    public function getAddress(String $hash): Address
    {
        try {
            $response = $this->getClient()->get('/address/' . $hash);
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

    public function getAddresses(int $count): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get('/address?size=' . $count);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            throw new AddressIndexIncompleteException(sprintf("Could not return top %d addresses", $count), 0, $e);
        }

        return $this->getMapper()->mapIterator(Addresses::class, $data);
    }
}
