<?php

namespace App\Controller;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\CommunityFund\Api\PaymentRequestApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use App\Navcoin\CommunityFund\Api\TrendApi;
use App\Navcoin\CommunityFund\Api\VotersApi;
use App\Navcoin\CommunityFund\Constants\PaymentRequestState;
use App\Navcoin\CommunityFund\Constants\PaymentRequestStatus;
use App\Navcoin\CommunityFund\Constants\ProposalState;
use App\Navcoin\CommunityFund\Constants\ProposalStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
     */
    public function indexAction(): RedirectResponse
    {
        return $this->redirectToRoute("app_dao_index", [], 301);
    }

    /**
     * @Route("/community-fund/proposals/{status}")
     */
    public function oldProposalsAction(Request $request) {
        return $this->redirectToRoute(
            "app_communityfund_proposals",
            ["status" => $request->get("status")],
            301
        );
    }

    /**
     * @Route("/dao/proposals/{status}")
     * @Template()
     */
    public function proposalsAction(Request $request)
    {
        switch($request->get('status')) {
            case ProposalStatus::PENDING:
                $state = ProposalState::PENDING;
                break;
            case ProposalStatus::ACCEPTED:
                $state = ProposalState::ACCEPTED;
                break;
            case ProposalStatus::REJECTED:
                $state = ProposalState::REJECTED;
                break;
            case ProposalStatus::EXPIRED:
                $state = ProposalState::EXPIRED;
                break;
            case ProposalStatus::PENDING_FUNDS:
                $state = ProposalState::PENDING_FUNDS;
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
     */
    public function oldViewAction(Request $request)
    {
        return $this->redirectToRoute(
            "app_communityfund_view",
            ["hash" => $request->get("hash")],
            301
        );
    }

    /**
     * @Route("/dao/proposal/{hash}")
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
            'paymentRequests' => $this->paymentRequestApi->getPaymentRequests(['proposal' => $proposal->getHash()]),
            'block' => $block,
            'votes' => $this->votersApi->getProposalVotes($proposal->getHash()),
        ];
    }

    /**
     * @Route("/community-fund/payment-requests/{status}")
     * @Template()
     */
    public function oldPaymentRequestsAction(Request $request)
    {
        return $this->redirectToRoute(
            "app_communityfund_paymentrequests",
            ["status" => $request->get("status")],
            301
        );
    }

    /**
     * @Route("/dao/payment-requests/{status}")
     * @Template()
     */
    public function paymentRequestsAction(Request $request)
    {
        switch($request->get('status')) {
            case PaymentRequestStatus::PENDING:
                $state = PaymentRequestState::PENDING;
                break;
            case PaymentRequestStatus::ACCEPTED:
                $state = PaymentRequestState::ACCEPTED;
                break;
            case PaymentRequestStatus::REJECTED:
                $state = PaymentRequestState::REJECTED;
                break;
            case PaymentRequestStatus::EXPIRED:
                $state = PaymentRequestState::EXPIRED;
                break;
            case PaymentRequestStatus::PAID:
                $state = PaymentRequestState::PAID;
                break;
            default:
                return $this->redirectToRoute('app_communityfund_paymentrequests', ['status' => PaymentRequestStatus::PENDING]);
        }

        $paymentRequests = $this->paymentRequestApi->getPaymentRequests(['state' => $state], 9, $request->get('page', 1), true);

        return [
            'blockHeight' => $this->blockApi->getBestBlock()->getHeight(),
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'paymentRequests' => $paymentRequests->getElements(),
            'paginator' => $paymentRequests->getPaginator(),
            'active' => $request->get('status'),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/payment-requests")
     * @Template()
     */
    public function oldViewPaymentRequestsAction(Request $request)
    {
        return $this->redirectToRoute(
            "app_communityfund_viewpaymentrequests",
            ["hash" => $request->get("hash")],
            301
        );
    }

    /**
     * @Route("/dao/proposal/{hash}/payment-requests")
     */
    public function viewPaymentRequestsAction(Request $request)
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        if ($proposal->getState() !== "ACCEPTED") {
            return $this->redirectToRoute('app_communityfund_view', ['hash' => $proposal->getHash()]);
        }

        return [
            'tab' => 'payments',
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'proposal' => $proposal,
            'paymentRequests' => $this->paymentRequestApi->getPaymentRequests(['proposalHash' => $proposal]),
        ];
    }

    /**
     * @Route("/community-fund/payment-request/{hash}")
     */
    public function oldViewPaymentRequestAction(Request $request)
    {
        return $this->redirectToRoute(
            "app_communityfund_viewpaymentrequest",
            ["hash" => $request->get("hash")],
            301
        );
    }

    /**
     * @Route("/dao/payment-request/{hash}")
     */
    public function viewPaymentRequestAction(Request $request)
    {
        $paymentRequest = $this->paymentRequestApi->getPaymentRequest($request->get('hash'));

        return [
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'proposal' => $this->proposalApi->getProposal($paymentRequest->getProposalHash()),
            'paymentRequest' => $paymentRequest,
            'votes' => $this->votersApi->getPaymentRequestVotes($request->get('hash')),
        ];
    }

    /**
     * @Route("/community-fund/proposal/{hash}/trend.json")
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
