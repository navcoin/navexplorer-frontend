<?php

namespace App\Navcoin\Block\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Block\Entity\BlockGroups;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

class BlockGroupApi extends NavcoinApi
{
    public function getGroupByCategory(string $period, $count = 10): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get(sprintf('/blockgroup?period=%s&count=%d', $period, $count));
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new BlockGroups();
        }

        /** @var BlockGroups $blockGroups */
        $blockGroups = $this->getMapper()->mapIterator(BlockGroups::class, $data);
        $blockGroups->setPeriod($period);

        return $blockGroups;
    }
}
