<?php

namespace App\Navcoin\Address\Type;

/**
 * Class AddressTransactionType
 *
 * @package App\Navcoin\Address\Type
 */
abstract class AddressTransactionType
{
    const STAKING = 'staking';
    const SENT = 'sent';
    const RECEIVED = 'received';
}
