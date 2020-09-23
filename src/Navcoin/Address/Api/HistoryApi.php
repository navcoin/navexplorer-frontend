<?php

namespace App\Navcoin\Address\Api;

use App\Exception\AddressIndexIncompleteException;
use App\Exception\AddressInvalidException;
use App\Exception\AddressNotFoundException;
use App\Exception\ServerRequestException;
use App\Navcoin\Address\Entity\Address;
use App\Navcoin\Address\Entity\Addresses;
use App\Navcoin\Address\Entity\Historys;
use App\Navcoin\Address\Entity\Transactions;
use App\Navcoin\Address\Type\Filter\AddressTransactionTypeFilter;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class HistoryApi extends NavcoinApi
{
    public function getAddressHistory(String $hash, int $size, int $page, string $type): IteratorEntityInterface
    {
        $url = sprintf('/address/%s/history?type=%s&size=%d&page=%d', $hash, $type, $size, $page);

        try {
            $response = $this->getClient()->get($url);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Historys();
        }

        return $this->getMapper()->mapIterator(Historys::class, $data, $this->getClient()->getPaginator($response));
    }
}
