<?php

namespace App\Controller\Api;

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
        $response = new Response($serializer->serialize($softForkApi->getAll()->getElements(), 'json'), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
