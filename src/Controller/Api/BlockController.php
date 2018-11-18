<?php

namespace App\Controller\Api;

use App\Navcoin\Block\Api\BlockApi;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BlockController
{
    /**
     * @var BlockApi
     */
    private $blockApi;

    public function __construct(BlockApi $blockApi)
    {
        $this->blockApi = $blockApi;
    }

    /**
     * @Route("/api/block/height")
     *
     * @return Response
     */
    public function getBlockHeight(): Response
    {
        $bestBlock = $this->blockApi->getBestBlock();

        return new Response($bestBlock->getHeight(),200);
    }
}
