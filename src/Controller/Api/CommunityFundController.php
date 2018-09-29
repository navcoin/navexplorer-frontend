<?php

namespace App\Controller\Api;

use App\Navcoin\CommunityFund\Api\PaymentRequestApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CommunityFundController
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
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ProposalApi $proposalApi, PaymentRequestApi $paymentRequestApi, SerializerInterface $serializer)
    {
        $this->proposalApi = $proposalApi;
        $this->paymentRequestApi = $paymentRequestApi;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/api/community-fund/proposal")
     *
     * @param Request             $request
     *
     * @return Response
     */
    public function getProposalsAction(Request $request): Response
    {
        if ($request->get('state')) {
            $proposals = $this->proposalApi->getProposalsByState(strtoupper($request->get('state', null)));
        } else {
            $proposals = $this->proposalApi->getAll();
        }

        return new Response(
            $this->serializer->serialize($proposals->getElements(), 'json'),
            200,
            ['Content-Type', 'application/json']
        );
    }

    /**
     * @Route("/api/community-fund/proposal/{hash}")
     *
     * @param Request             $request
     *
     * @return Response
     */
    public function getProposalByHashAction(Request $request): Response
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        return new Response(
            $this->serializer->serialize($proposal, 'json'),
            200,
            ['Content-Type', 'application/json']
        );
    }

    /**
     * @Route("/api/community-fund/proposal/{hash}/payment-request")
     *
     * @param Request             $request
     *
     * @return Response
     */
    public function getPaymentRequestsAction(Request $request): Response
    {
        $proposal = $this->proposalApi->getProposal($request->get('hash'));

        if ($request->get('state')) {
            $paymentRequests = $this->paymentRequestApi->getPaymentRequestsForProposalByState($proposal, $request->get('state'));
        } else {
            $paymentRequests = $this->paymentRequestApi->getAll($proposal);
        }

        return new Response(
            $this->serializer->serialize($paymentRequests->getElements(), 'json'),
            200,
            ['Content-Type', 'application/json']
        );
    }
}
