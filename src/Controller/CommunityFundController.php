<?php

namespace App\Controller;

use App\Navcoin\CommunityFund\Api\CommunityFundApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CommunityFundController extends Controller
{
    /**
     * @var CommunityFundApi
     */
    private $communityFundApi;

    public function __construct(CommunityFundApi $communityFundApi)
    {
        $this->communityFundApi = $communityFundApi;
    }

    /**
     * @Route("/community-fund")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'blockCycle' => $this->communityFundApi->getBlockCycle(),
            'proposals' => [
                'pending' => $this->communityFundApi->getProposalsByStatus("PENDING"),
                'accepted' => $this->communityFundApi->getProposalsByStatus("ACCEPTED"),
            ]
        ];
    }
}
