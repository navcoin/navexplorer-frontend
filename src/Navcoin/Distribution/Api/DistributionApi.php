<?php

namespace App\Navcoin\Distribution\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Distribution\Entity\Distribution;
use App\Exception\DistributionException;
use App\Exception\ServerRequestException;

/**
 * Class DistributionApi
 *
 * @package App\Navcoin\Distribution\Api
 */
class DistributionApi extends NavcoinApi
{
    /**
     * Get transactions
     *
     * @param String $groups
     *
     * @return Distribution
     */
    public function getBalanceDistribution(String $groups): Distribution
    {
        try {
            $data = $this->getClient()->get('/api/distribution/balance?groups='.$groups);
        } catch (ServerRequestException $e) {
            throw new DistributionException(sprintf("The distribution cannot be created."), 500, $e);
        }

        return $this->getMapper()->mapIterator($data);
    }
}
