<?php

namespace App\Navcoin\Address\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Address\Type\Filter\AddressTransactionTypeFilter;
use App\Navcoin\Address\Entity\Transactions;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

class TransactionApi extends NavcoinApi
{
    /**
     * @var AddressTransactionTypeFilter
     */
    private $addressTransactionTypeFilter;

    public function setFilter(AddressTransactionTypeFilter $addressTransactionTypeFilter)
    {
        $this->addressTransactionTypeFilter = $addressTransactionTypeFilter;
    }

    public function getTransactionsForAddress(
        String $hash,
        int $size = 50,
        array $filters = null,
        String $from = null,
        String $to = null
    ): IteratorEntityInterface
    {
        $url = sprintf('/api/address/%s/tx?page=%d&size=%d', $hash,0, $size);
        if (!empty($filters)) {
            $filterQuery = $this->addressTransactionTypeFilter->createfilterQuery($filters);
            $url .= ($filterQuery !== '') ? '&' . $filterQuery : '';
        }
        $url .= ($from !== null) ? sprintf('&from=%s', $from) : '';
        $url .= ($to !== null) ? sprintf('&to=%s', $to) : '';

        try {
            $data = $this->getClient()->get($url);
        } catch (ServerRequestException $e) {
            return new Transactions();
        }

        return $this->getMapper()->mapIterator($data, Transactions::class);
    }

    public function getColdTransactionsForAddress(
        String $hash,
        int $size = 50,
        array $filters = null,
        String $from = null,
        String $to = null
    ): IteratorEntityInterface
    {
        $url = sprintf('/api/address/%s/coldtx?page=%d&size=%d', $hash,0, $size);
        if (!empty($filters)) {
            $filterQuery = $this->addressTransactionTypeFilter->createfilterQuery($filters);
            $url .= ($filterQuery !== '') ? '&' . $filterQuery : '';
        }
        $url .= ($from !== null) ? sprintf('&from=%s', $from) : '';
        $url .= ($to !== null) ? sprintf('&to=%s', $to) : '';

        try {
            $data = $this->getClient()->get($url);
        } catch (ServerRequestException $e) {
            return new Transactions();
        }

        return $this->getMapper()->mapIterator($data, Transactions::class);
    }
}
