<?php

namespace App\Navcoin\Address\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Address\Type\Filter\AddressTransactionTypeFilter;
use App\Navcoin\Address\Entity\Transactions;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

/**
 * Class TransactionApi
 *
 * @package App\Navcoin\Address\Api
 */
class TransactionApi extends NavcoinApi
{
    /**
     * @var AddressTransactionTypeFilter
     */
    private $addressTransactionTypeFilter;

    /**
     * Set Filter
     *
     * @param AddressTransactionTypeFilter $addressTransactionTypeFilter
     */
    public function setFilter(AddressTransactionTypeFilter $addressTransactionTypeFilter)
    {
        $this->addressTransactionTypeFilter = $addressTransactionTypeFilter;
    }

    /**
     * Get transactions for address
     *
     * @param String      $hash
     * @param int         $size
     * @param array       $filters
     * @param String|null $from
     * @param String|null $to
     *
     * @return IteratorEntityInterface
     */
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
}
