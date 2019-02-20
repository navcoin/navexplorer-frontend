<?php

namespace App\Controller;

use App\Navcoin\Distribution\Api\DistributionApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DistributionController
 *
 * @package App\Controller
 */
class DistributionController
{
    /**
     * @var DistributionApi
     */
    private $distributionApi;

    /**
     * Constructor
     *
     * @param DistributionApi $distributionApi
     */
    public function __construct(DistributionApi $distributionApi)
    {
        $this->distributionApi = $distributionApi;
    }


    /**
     * @Route("/distribution/balance.json")
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function balance(SerializerInterface $serializer)
    {
        return new Response(
            $serializer->serialize(
                $this->distributionApi->getBalanceDistribution(),
                'json'
            )
        );
    }
}
