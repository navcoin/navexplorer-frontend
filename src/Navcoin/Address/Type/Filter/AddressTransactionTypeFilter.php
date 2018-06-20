<?php

namespace App\Navcoin\Address\Type\Filter;

use App\Navcoin\Common\AbstractFilter;
use App\Navcoin\Address\Type\AddressTransactionType;

/**
 * Class AddressTransactionTypeFilter
 *
 * @package App\Navcoin\Address\Type\Filter
 */
class AddressTransactionTypeFilter extends AbstractFilter
{
    /**
     * @inheritdoc
     */
    public function setClass() {
        $this->class = AddressTransactionType::class;
    }
}
