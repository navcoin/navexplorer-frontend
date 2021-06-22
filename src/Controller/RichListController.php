<?php

namespace App\Controller;

use App\Navcoin\Address\Api\AddressApi;
use App\Navcoin\Block\Api\BlockApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class RichListController
{
    /**
     * @Route("/rich-list")
     * @Template()
     */
    public function index(AddressApi $addressApi, BlockApi $blockApi)
    {
        $count = 100;

        return [
            'count' => $count,
            'richList' => $addressApi->getAddresses($count),
            'bestBlock' => $blockApi->getBestBlock()
        ];
    }
}
