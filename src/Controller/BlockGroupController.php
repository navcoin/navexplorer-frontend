<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockGroupApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlockGroupController
{
    /**
     * @Route("/block/group/{category}.json")
     */
    public function blocks(Request $request, SerializerInterface $serializer, BlockGroupApi $blockGroupApi): Response
    {
        $blockGroups = $blockGroupApi->getGroupByCategory(
            $request->get('category'),
            $request->get('count', 10)
        );

        return new Response($serializer->serialize($blockGroups, 'json'));
    }
}
