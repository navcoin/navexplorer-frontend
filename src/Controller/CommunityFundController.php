<?php

namespace App\Controller;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
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

    /**
     * @var BlockApi
     */
    private $blockApi;

    public function __construct(ProposalApi $proposalApi, PaymentRequestApi $paymentRequestApi, BlockApi $blockApi)
    {
        $this->proposalApi = $proposalApi;
        $this->paymentRequestApi = $paymentRequestApi;
        $this->blockApi = $blockApi;
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
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        $block = null;
        if ($proposal->getState() == 'ACCEPTED' && $proposal->getStateChangedOnBlock()) {
            try {
                $block = $this->blockApi->getBlock($proposal->getStateChangedOnBlock());
            } catch (BlockNotFoundException $e) {
                //
            }
        }

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $this->proposalApi->getProposal($request->get('hash')),
            'paymentRequests' => $this->paymentRequestApi->getPaymentRequests($proposal),
            'block' => $block,
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/payment-requests")
     * @Template()
     *
     * @return array|RedirectResponse
     */
    public function viewPaymentRequestsAction(Request $request)
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        if ($proposal->getState() !== "ACCEPTED") {
            return $this->redirectToRoute('app_communityfund_view', ['hash' => $proposal->getHash()]);
        }

        return [
            'tab' => 'payments',
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $proposal,
            'paymentRequests' => $this->paymentRequestApi->getPaymentRequests($proposal),
        ];
    }
}
