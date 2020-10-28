<?php

namespace App\Navcoin\Address\Type\Filter;

use App\Navcoin\Common\AbstractFilter;
use App\Navcoin\Address\Type\AddressTransactionType;

class AddressTransactionTypeFilter extends AbstractFilter
{
    public function setClass() {
        $this->class = AddressTransactionType::class;
    }
}
