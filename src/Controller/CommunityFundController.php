<?php

namespace App\Controller;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\CommunityFund\Api\PaymentRequestApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use App\Navcoin\CommunityFund\Api\TrendApi;
use App\Navcoin\CommunityFund\Api\VotersApi;
use App\Navcoin\CommunityFund\Constants\ProposalState;
use App\Navcoin\CommunityFund\Constants\ProposalStatus;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunityFundController extends AbstractController
{
    /** @var ProposalApi */
    private $proposalApi;

    /** @var PaymentRequestApi */
    private $paymentRequestApi;

    /** @var VotersApi */
    private $votersApi;

    /** @var TrendApi */
    private $trendApi;

    /** @var BlockApi */
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
     * @Route("/community-fund")
     * @Template()
     */
    public function indexAction(): array
    {
        return [
            'stats' => $this->proposalApi->getStats(),
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'proposals' => $this->proposalApi->getProposals(['state' => ProposalState::PENDING], 5),
            'paymentRequests' => $this->paymentRequestApi->getByStatus("pending", "id"),
        ];
    }

    /**
     * @Route("/community-fund/proposals/{status}")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function proposalsAction(Request $request)
    {
        switch($request->get('status')) {
            case ProposalStatus::PENDING:
                $state = ProposalState::PENDING;
                $order = 'votes';
                break;
            case ProposalStatus::ACCEPTED:
                $state = ProposalState::ACCEPTED;
                $order = 'id';
                break;
            case ProposalStatus::REJECTED:
                $state = ProposalState::REJECTED;
                $order = 'id';
                break;
            case ProposalStatus::EXPIRED:
                $state = ProposalState::EXPIRED;
                $order = 'id';
                break;
            case ProposalStatus::PENDING_FUNDS:
                $state = ProposalState::PENDING_FUNDS;
                $order = 'id';
                break;
            default:
                return $this->redirectToRoute('app_communityfund_proposals', ['status' => ProposalStatus::PENDING]);
        }

        $proposals = $this->proposalApi->getProposals(['state' => $state], 9, $request->get('page', 1), true);

        return [
            'blockHeight' => $this->blockApi->getBestBlock()->getHeight(),
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'proposals' => $proposals->getElements(),
            'paginator' => $proposals->getPaginator(),
            'active' => $request->get('status'),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}")
     * @Template()
     */
    public function viewAction(Request $request)
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        $block = null;
        if ($proposal->getState() == ProposalStatus::ACCEPTED && $proposal->getStateChangedOnBlock()) {
            try {
                $block = $this->blockApi->getBlock($proposal->getStateChangedOnBlock());
            } catch (BlockNotFoundException $e) {
                //
            }
        }

        return [
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'proposal' => $proposal,
            'paymentRequests' => $this->paymentRequestApi->getPaymentRequests($proposal),
            'block' => $block,
            'votes' => $this->votersApi->getProposalVotes($proposal->getHash()),
        ];
    }

    /**
     * @Route("/community-fund/payment-requests/{state}")
     * @Template()
     */
    public function paymentRequestsAction(Request $request)
    {
        switch($request->get('state')) {
            case 'pending':
            case 'accepted':
            case 'paid':
            case 'rejected':
            case 'expired':
                $paymentRequests = $this->paymentRequestApi->getByStatus($request->get('state'));
                break;
            default:
                return $this->redirectToRoute('app_communityfund_paymentrequests', ['state' => 'pending']);
        }

        return [
            'stats' => $this->proposalApi->getStats(),
            'blockHeight' => $this->blockApi->getBestBlock()->getHeight(),
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'paymentRequests' => $paymentRequests,
            'active' => $request->get('state'),
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
     * @Route("/community-fund/payment-request/{hash}")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function viewPaymentRequestAction(Request $request)
    {
        $paymentRequest = $this->paymentRequestApi->getPaymentRequest($request->get('hash'));

        $block = null;
        if ($paymentRequest->getState() == 'ACCEPTED' && $paymentRequest->getStateChangedOnBlock()) {
            try {
                $block = $this->blockApi->getBlock($paymentRequest->getStateChangedOnBlock());
            } catch (BlockNotFoundException $e) {
                //
            }
        }

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'proposal' => $this->proposalApi->getProposal($paymentRequest->getProposalHash()),
            'paymentRequest' => $paymentRequest,
            'block' => $block,
            'votes' => $this->votersApi->getPaymentRequestVotes($request->get('hash')),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/trend.json")
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function proposalVoteTrends(Request $request, SerializerInterface $serializer): Response
    {
        return new Response(
            $serializer->serialize(
                $this->trendApi->getProposalVotingTrend($request->get('hash')),
                'json'
            )
        );
    }

    /**
     * @Route("/community-fund/payment-request/{hash}/trend.json")
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function paymentRequestVoteTrends(Request $request, SerializerInterface $serializer): Response
    {
        return new Response(
            $serializer->serialize(
                $this->trendApi->getPaymentRequestVotingTrend($request->get('hash')),
                'json'
            )
        );
    }
}
