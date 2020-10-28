<?php

namespace App\Navcoin\Dao\Constants;

class ConsultationState
{
    const WAITING_FOR_SUPPORT = 0;
    const VOTING_STARTED = 1;
    const EXPIRED = 3;
    const PASSED = 7;
    const REFLECTION = 8;
    const FOUND_SUPPORT = 9;
}