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
     *
     * @param AddressApi $addressApi
     * @param BlockApi   $blockApi
     *
     * @return array
     */
    public function index(AddressApi $addressApi, BlockApi $blockApi)
    {
        return [
            'richList' => $addressApi->getTop100Addresses(),
            'bestBlock' => $blockApi->getBestBlock()
        ];
    }
}
