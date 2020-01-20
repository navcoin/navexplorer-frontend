<?php

namespace App\Navcoin\Address\Api;

use App\Exception\ServerRequestException;
use App\Exception\StakingReportUnavailableException;
use App\Navcoin\Address\Entity\StakingGroups;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

class StakingApi extends NavcoinApi
{
    public function getStakingReport(string $hash, string $period): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get('/address/' . $hash . '/staking?period='.$period);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            throw new StakingReportUnavailableException(sprintf("Could not return staking report for address: %s", $hash), 0, $e);
        }


        /** @var StakingGroups $stakingGroups */
        $stakingGroups = $this->getMapper()->mapIterator(StakingGroups::class, $data);
        $stakingGroups->setPeriod($period);

        return $stakingGroups;
    }
}
