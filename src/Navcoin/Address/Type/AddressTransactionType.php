<?php

namespace App\Navcoin\Address\Type;

abstract class AddressTransactionType
{
    const STAKE = 'stake';
    const SENT = 'send';
    const RECEIVED = 'receive';
}
