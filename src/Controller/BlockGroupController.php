<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockGroupApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlockGroupController
 *
 * @package App\Controller
 */
class BlockGroupController
{
    /**
     * @var BlockGroupApi
     */
    private $blockGroupApi;

    /**
     * Constructor
     *
     * @param BlockGroupApi $blockGroupApi
     */
    public function __construct(BlockGroupApi $blockGroupApi)
    {
        $this->blockGroupApi = $blockGroupApi;
    }


    /**
     * @Route("/block/group/{category}.json")
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function blocks(Request $request, SerializerInterface $serializer): Response
    {
        $blockGroups = $this->blockGroupApi->getGroupByCategory(
            $request->get('category'),
            $request->get('count', 10)
        );

        return new Response($serializer->serialize($blockGroups, 'json'));
    }
}
