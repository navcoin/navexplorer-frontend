<?php

namespace App\Navcoin\CommunityFund\Constants;

class PaymentRequestState
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;
    const EXPIRED = 4;
    const PAID = 6;
}