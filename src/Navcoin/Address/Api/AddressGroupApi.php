<?php

namespace App\Navcoin\Address\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Address\Entity\AddressGroups;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;

class AddressGroupApi extends NavcoinApi
{
    public function getGroupByCategory(string $period, $count = 10): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get(sprintf('/addressgroup?period=%s&count=%d', $period, $count));
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new AddressGroups();
        }

        /** @var AddressGroups $addressGroups */
        $addressGroups = $this->getMapper()->mapIterator(AddressGroups::class, $data);
        $addressGroups->setPeriod($period);

        return $addressGroups;
    }
}
