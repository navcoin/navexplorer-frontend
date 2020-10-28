<?php

namespace App\Controller;

use App\Navcoin\Distribution\Api\DistributionApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistributionController
{
    /**
     * @Route("/distribution/balance.json")
     */
    public function balance(SerializerInterface $serializer, DistributionApi $distributionApi)
    {
        return new Response($serializer->serialize($distributionApi->getBalanceDistribution(),'json'));
    }
}
