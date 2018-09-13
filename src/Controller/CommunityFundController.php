<?php

namespace App\Controller;

use App\Navcoin\CommunityFund\Api\CommunityFundApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @return RedirectResponse
     */
    public function redirectAction()
    {
        return $this->redirectToRoute('app_communityfund_index', ['state' => 'pending']);
    }

    /**
     * @Route("/community-fund/proposals/{state}")
     * @Template()
     *
     * @return array|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        switch($request->get('state')) {
            case 'pending':
                $proposals = $this->communityFundApi->getProposalsByState("PENDING", "votes");
                break;
            case 'accepted':
                $proposals = $this->communityFundApi->getProposalsByState("ACCEPTED");
                break;
            case 'rejected':
                $proposals = $this->communityFundApi->getProposalsByState("REJECTED");
                break;
            case 'expired':
                $proposals = $this->communityFundApi->getProposalsByState("EXPIRED");
                break;
            case 'pending-funds':
                $proposals = $this->communityFundApi->getProposalsByState("PENDING_FUNDS");
                break;
            default:
                return $this->redirectToRoute('app_communityfund_index', ['state' => 'pending']);
        }

        return [
            'blockCycle' => $this->communityFundApi->getBlockCycle(),
            'proposals' => $proposals,
            'active' => $request->get('state'),
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
            'blockCycle' => $this->communityFundApi->getBlockCycle(),
            'proposal' => $this->communityFundApi->getProposal($request->get('hash')),
        ];
    }
}
