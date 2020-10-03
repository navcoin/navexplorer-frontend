<?php

namespace App\Controller;

use App\Navcoin\Address\Api\AddressGroupApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressGroupController
{
    /** @var AddressGroupApi */
    private $addressGroupApi;

    public function __construct(AddressGroupApi $addressGroupApi)
    {
        $this->addressGroupApi = $addressGroupApi;
    }

    /**
     * @Route("/address/group/{category}.json")
     */
    public function blocks(Request $request, SerializerInterface $serializer): Response
    {
        $addressGroups = $this->addressGroupApi->getGroupByCategory(
            $request->get('category'),
            $request->get('count', 10)
        );

        return new Response($serializer->serialize($addressGroups, 'json'));
    }
}
