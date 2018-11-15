<?php

namespace App\Controller;

use App\Navcoin\Address\Api\AddressApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class RichListController
{
    /**
     * @var AddressApi
     */
    private $addressApi;

    public function __construct(AddressApi $addressApi)
    {
        $this->addressApi = $addressApi;
    }

    /**
     * @Route("/rich-list")
     * @Template()
     *
     * @return array
     */
    public function index()
    {
        return [
            'richList' => $this->addressApi->getTop100Addresses()
        ];
    }
}
