<?php

namespace App\Controller\Api;

use App\Navcoin\Common\Network;
use App\Navcoin\SoftFork\Api\SoftForkApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SoftForkController
{
    /**
     * @Route("/api/soft-forks")
     *
     * @param Request             $request
     * @param SoftForkApi         $softForkApi
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getSoftForksAction(Request $request, SoftForkApi $softForkApi, SerializerInterface $serializer)
    {
        switch ($request->headers->get('network')) {
            case 'testnet':
                $softForkApi->useNetwork(Network::TEST_NET);
                break;
            default:
                $softForkApi->useNetwork(Network::MAIN_NET);
        }

        $response = new Response($serializer->serialize($softForkApi->getAll()->getElements(), 'json'), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
