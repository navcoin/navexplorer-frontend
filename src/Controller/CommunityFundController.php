<?php

namespace App\Controller;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Address\Api\AddressApi;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\CommunityFund\Api\PaymentRequestApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use App\Navcoin\CommunityFund\Api\TrendApi;
use App\Navcoin\CommunityFund\Api\VotersApi;
use App\Navcoin\SoftFork\Api\SoftForkApi;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @var VotersApi
     */
    private $votersApi;

    /**
     * @var TrendApi
     */
    private $trendApi;

    /**
     * @var BlockApi
     */
    private $blockApi;

    public function __construct(
        ProposalApi $proposalApi,
        PaymentRequestApi $paymentRequestApi,
        VotersApi $votersApi,
        TrendApi $trendApi,
        BlockApi $blockApi
    ) {
        $this->proposalApi = $proposalApi;
        $this->paymentRequestApi = $paymentRequestApi;
        $this->votersApi = $votersApi;
        $this->trendApi = $trendApi;
        $this->blockApi = $blockApi;
    }

    /**
     * @Route("/community-fund/proposals")
     * @Template()
     *
     * @return RedirectResponse
     */
    public function redirectAction(): RedirectResponse
    {
        return $this->redirectToRoute('app_communityfund_proposals', ['state' => 'pending']);
    }

    /**
     * @Route("/community-fund/proposals/{state}")
     * @Template()
     *
     * @param Request $request
     * @param AddressApi $addressApi
     * @param SoftForkApi $softForkApi
     *
     * @return array|RedirectResponse
     */
    public function proposalsAction(Request $request, AddressApi $addressApi, SoftForkApi $softForkApi)
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
                return $this->redirectToRoute('app_communityfund_proposals', ['state' => 'pending']);
        }

        return [
            'stats' => $this->proposalApi->getStats(),
            'softFork' => $softForkApi->getByName("C FUND"),
            'blockHeight' => $this->blockApi->getBestBlock()->getHeight(),
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposals' => $proposals,
            'active' => $request->get('state'),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}")
     * @Template()
     *
     * @param Request $request
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
            'votesYes' => $this->votersApi->getProposalVotes($request->get('hash'), true),
            'votesNo' => $this->votersApi->getProposalVotes($request->get('hash'), false),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/payment-requests")
     * @Template()
     *
     * @param Request $request
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

    /**
     * @Route("/community-fund/proposal/{hash}/trend.json")
     *
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function transactions(Request $request, SerializerInterface $serializer): Response
    {
        $transactions = $this->trendApi->getProposalVotingTrend($request->get('hash'));

        return new Response($serializer->serialize($transactions, 'json'));
    }
}
