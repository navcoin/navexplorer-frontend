<?php

namespace App\Navcoin\Block\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Block\Entity\BlockGroups;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

class BlockGroupApi extends NavcoinApi
{
    public function getGroupByCategory(string $category, $count = 10): IteratorEntityInterface
    {
        try {
            $data = $this->getClient()->get(sprintf('/api/group/block/%s/%d', $category, $count));
        } catch (ServerRequestException $e) {
            return new BlockGroups();
        }

        return $this->getMapper()->mapIterator($data, BlockGroups::class);
    }
}
