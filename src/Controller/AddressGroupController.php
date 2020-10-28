<?php

namespace App\Controller;

use App\Navcoin\Address\Api\AddressGroupApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressGroupController
{
    /**
     * @Route("/address/group/{category}/{days}.json")
     */
    public function blocks(Request $request, SerializerInterface $serializer, AddressGroupApi $addressGroupApi): Response
    {
        $addressGroups = $addressGroupApi->getGroupByCategory(
            $request->get('category'),
            $request->get('days', 10)
        );

        return new Response($serializer->serialize($addressGroups, 'json'));
    }
}
