<?php

namespace App\Controller;

use App\Navcoin\CommunityFund\Api\CommunityFundApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/community-fund/proposals")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'blockCycle' => $this->communityFundApi->getBlockCycle(),
            'proposals' => [
                'pending' => $this->communityFundApi->getProposalsByState("PENDING", "votes"),
                'accepted' => $this->communityFundApi->getProposalsByState("ACCEPTED"),
                'rejected' => $this->communityFundApi->getProposalsByState("REJECTED"),
                'expired' => $this->communityFundApi->getProposalsByState("EXPIRED"),
                'pendingFunds' => $this->communityFundApi->getProposalsByState("PENDING_FUNDS"),
            ]
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}")
     * @Template()
     *
     * @return array
     */
    public function viewAction(Request $request)
    {
        return [
            'proposal' => $this->communityFundApi->getProposal($request->get('hash')),
        ];
    }
}
