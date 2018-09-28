<?php

namespace App\Controller;

use App\Navcoin\CommunityFund\Api\PaymentRequestApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommunityFundController extends Controller
{
    /**
     * @var ProposalApi
     */
    private $proposalApi;

    /**
     * @var PaymentRequestApi
     */
    private $paymentRequestApi;

    public function __construct(ProposalApi $proposalApi, PaymentRequestApi $paymentRequestApi)
    {
        $this->proposalApi = $proposalApi;
        $this->paymentRequestApi = $paymentRequestApi;
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
                $proposals = $this->proposalApi->getProposalsByState("PENDING", "votes");
                break;
            case 'accepted':
                $proposals = $this->proposalApi->getProposalsByState("ACCEPTED");
                break;
            case 'rejected':
                $proposals = $this->proposalApi->getProposalsByState("REJECTED");
                break;
            case 'expired':
                $proposals = $this->proposalApi->getProposalsByState("EXPIRED");
                break;
            case 'pending-funds':
                $proposals = $this->proposalApi->getProposalsByState("PENDING_FUNDS");
                break;
            default:
                return $this->redirectToRoute('app_communityfund_index', ['state' => 'pending']);
        }

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
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
            'tab' => 'details',
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $this->proposalApi->getProposal($request->get('hash')),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/voting")
     * @Template()
     *
     * @return array
     */
    public function viewVotingAction(Request $request)
    {
        return [
            'tab' => 'voting',
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $this->proposalApi->getProposal($request->get('hash')),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/payment-requests/{state}")
     * @Template()
     *
     * @return array|RedirectResponse
     */
    public function viewPaymentRequestsAction(Request $request)
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        if ($proposal->wasApproved() === false) {
            return $this->redirectToRoute('app_communityfund_view', ['hash' => $proposal->getHash()]);
        }

        switch($request->get('state')) {
            case 'pending':
                $paymentRequests = $this->paymentRequestApi->getPaymentRequestsForProposalByState($proposal, "PENDING");
                break;
            case 'accepted':
                $paymentRequests = $this->paymentRequestApi->getPaymentRequestsForProposalByState($proposal, "ACCEPTED");
                break;
            case 'rejected':
                $paymentRequests = $this->paymentRequestApi->getPaymentRequestsForProposalByState($proposal, "REJECTED");
                break;
            case 'expired':
                $paymentRequests = $this->paymentRequestApi->getPaymentRequestsForProposalByState($proposal, "EXPIRED");
                break;
            default:
                return $this->redirectToRoute('app_communityfund_viewpaymentrequests', ['state' => 'pending']);
        }

        return [
            'tab' => 'payments',
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $proposal,
            'paymentRequests' => $paymentRequests,
            'active' => $request->get('state'),
        ];
    }
}
