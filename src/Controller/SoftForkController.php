<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\SoftFork\Api\SoftForkApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SoftForkController
 *
 * @package App\Controller
 */
class SoftForkController
{
    /**
     * @var SoftForkApi
     */
    private $softForkApi;

    /**
     * @var BlockApi
     */
    private $blockApi;

    /**
     * Constructor
     *
     * @param SoftForkApi $softForkApi
     * @param BlockApi $blockApi
     */
    public function __construct(SoftForkApi $softForkApi, BlockApi $blockApi)
    {
        $this->softForkApi = $softForkApi;
        $this->blockApi = $blockApi;
    }


    /**
     * @Route("/soft-forks")
     * @Template()
     *
     * @return array
     */
    public function index()
    {
        return [
            'block' => $this->blockApi->getBestBlock(),
            'softForks' => $this->softForkApi->getAll(),
        ];
    }
}
