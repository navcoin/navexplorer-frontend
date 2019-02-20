<?php

namespace App\Navcoin\Address\Type;

abstract class AddressTransactionType
{
    const STAKING = 'staking';
    const SENT = 'send';
    const RECEIVED = 'receive';
}
