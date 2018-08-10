<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class CommunityFundController
{
    /**
     * @Route("/community-fund")
     * @Template()
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }

}
