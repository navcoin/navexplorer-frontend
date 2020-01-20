<?php

namespace App\Navcoin\Distribution\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Distribution\Entity\Distribution;
use App\Exception\DistributionException;
use GuzzleHttp\Exception\ClientException;

class DistributionApi extends NavcoinApi
{
    public function getBalanceDistribution(String $groups = null): Distribution
    {
        try {
            $response = $this->getClient()->get('/coin/wealth?groups=' . $groups);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new DistributionException(sprintf("The distribution cannot be created."), 500, $e);
        }

        return $this->getMapper()->mapIterator(Distribution::class, $data);
    }
}
