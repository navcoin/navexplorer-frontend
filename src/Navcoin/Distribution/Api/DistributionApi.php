<?php

namespace App\Navcoin\Distribution\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Distribution\Entity\Distribution;
use App\Exception\DistributionException;
use GuzzleHttp\Exception\ClientException;

class DistributionApi extends NavcoinApi
{
    public function getSupply(): array
    {
        try {
            $response = $this->getClient()->get('/distribution/supply');
            return $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new DistributionException("Total supply could not be retrieved", 500, $e);
        }
    }
    public function getWealth(String $groups = null): Distribution
    {
        try {
            $response = $this->getClient()->get('/distribution/wealth?groups=' . $groups);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new DistributionException(sprintf("The distribution cannot be created."), 500, $e);
        }

        return $this->getMapper()->mapIterator(Distribution::class, $data);
    }
}
