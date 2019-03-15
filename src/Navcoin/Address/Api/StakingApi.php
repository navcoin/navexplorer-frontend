<?php

namespace App\Navcoin\Address\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;

class StakingApi extends NavcoinApi
{
    public function getStakingReport(String $hash, \DateTime $from, \DateTime $to)
    {
        try {
            $data = $this->getClient()->get(sprintf('/api/staking/report/%s?from=%s&to=%s',
                $hash, $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s')
            ));
        } catch (ServerRequestException $e) {
            throw $e;
        }

        return $data;
    }
}
