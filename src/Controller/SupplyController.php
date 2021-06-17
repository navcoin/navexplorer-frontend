<?php

namespace App\Controller;

use App\Navcoin\Supply\Api\SupplyApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SupplyController
{
    private static $DEFAULT_BLOCKS = 20160;

    /**
     * @Route("/supply.json")
     */
    public function supply(Request $request, SerializerInterface $serializer, SupplyApi $supplyApi): Response
    {
        $blocks = $request->get('blocks', self::$DEFAULT_BLOCKS);
        if ($blocks > self::$DEFAULT_BLOCKS) {
            $blocks = self::$DEFAULT_BLOCKS;
        }

        return new Response($serializer->serialize($supplyApi->getSupply($blocks),'json'));
    }
}
