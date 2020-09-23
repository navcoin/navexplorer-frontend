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

}
