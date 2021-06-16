<?php

namespace App\Controller;

use App\Navcoin\Distribution\Api\DistributionApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DistributionController
{
    /**
     * @Route("/distribution/balance.json")
     */
    public function balance(SerializerInterface $serializer, DistributionApi $distributionApi)
    {
        return new Response($serializer->serialize($distributionApi->getWealth("10,100,1000"),'json'));
    }
}
