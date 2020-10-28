<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\SoftFork\Api\SoftForkApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class SoftForkController
{
    /**
     * @Route("/soft-forks")
     * @Template()
     */
    public function index(SoftForkApi $softForkApi, BlockApi $blockApi)
    {
        $softForks = $softForkApi->getAll();
        $softForks->sortByLockedInHeight();

        return [
            'cycle' => $softForkApi->getCycle(),
            'block' => $blockApi->getBestBlock(),
            'softForks' => $softForks,
        ];
    }
}
