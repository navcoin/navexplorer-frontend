<?php

namespace App\Navcoin\Supply\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Exception\SupplyException;
use GuzzleHttp\Exception\ClientException;

class SupplyApi extends NavcoinApi
{
    public function getSupply(int $blocks): array
    {
        try {
            $response = $this->getClient()->get('/supply?blocks='.$blocks);
            $supply = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new SupplyException("Supply could not be retrieved", 500, $e);
        }

        return $supply;
    }
}
