<?php

namespace App\Controller;

use App\Exception\AddressInvalidException;
use App\Exception\AddressNotFoundException;
use App\Exception\StakingReportUnavailableException;
use App\Navcoin\Address\Api\AddressApi;
use App\Navcoin\Address\Api\StakingApi;
use App\Navcoin\Address\Api\TransactionApi;
use App\Navcoin\Address\Entity\StakingGroups;
use App\Navcoin\Address\Type\Filter\AddressTransactionTypeFilter;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends Controller
{
    /**
     * @var AddressApi
     */
    private $addressApi;

    /**
     * @var StakingApi
     */
    private $stakingApi;

    /**
     * @var TransactionApi
     */
    private $transactionApi;

    /**
     * @var int
     */
    private $pageSize = 50;

    public function __construct(AddressApi $addressApi, StakingApi $stakingApi, TransactionApi $transactionApi)
    {
        $this->addressApi = $addressApi;
        $this->stakingApi = $stakingApi;
        $this->transactionApi = $transactionApi;
    }

    /**
     * @Route("/address/{hash}")
     *
     * @param Request                      $request
     * @param string                       $hash
     * @param AddressTransactionTypeFilter $filter
     *
     * @return Response
     */
    public function index(Request $request, String $hash, AddressTransactionTypeFilter $filter): Response
    {
        if ($hash == 'Community Fund') {
            return $this->redirectToRoute('app_communityfund_index');
        }

        try {
            $address = $this->addressApi->getAddress($hash);
        } catch (AddressNotFoundException $e) {
            return $this->render('address/not_found.html.twig', [
                'hash' => $hash,
            ]);
        } catch (AddressInvalidException $e) {
            return $this->render('address/not_valid.html.twig', [
                'hash' => $hash,
            ]);
        }

        try {
            /** @var StakingGroups $stakingReport */
            $stakingReport = $this->stakingApi->getStakingReport(
                $hash,
                $request->get('period', "daily")
            );
        } catch (StakingReportUnavailableException $e) {
            $stakingReport = null;
        }

        return $this->render('address/index.html.twig', [
            'address' => $address,
            'hash' => $hash,
            'filter' => $filter,
            'filters' => $request->get('filters') ? explode(',', $request->get('filters')) : [],
            'stakingReport' => $stakingReport,
            'activeTab' => $request->get('period') ? 'staking-report' : 'transactions',
        ]);
    }

    /**
     * @Route("/address/{hash}/tx.json")
     *
     * @param Request             $request
     * @param string              $hash
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function transactions(Request $request, String $hash, SerializerInterface $serializer): Response
    {
        $addressTransactions = $this->transactionApi->getTransactionsForAddress(
            $hash,
            $request->get('size', $this->pageSize),
            $request->get('page', 1),
            $request->get('filters', [])
        );

        return new Response($serializer->serialize($addressTransactions, 'json'));
    }

    /**
     * @Route("/address/{hash}/cold-tx.json")
     *
     * @param Request             $request
     * @param string              $hash
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function coldTransactions(Request $request, String $hash, SerializerInterface $serializer): Response
    {
        $addressTransactions = $this->transactionApi->getColdTransactionsForAddress(
            $hash,
            $request->get('size', $this->pageSize),
            $request->get('page', 1),
            $request->get('filters', [])
        );

        return new Response($serializer->serialize($addressTransactions, 'json'));
    }

    /**
     * @Route("/address/{hash}/staking.json")
     *
     * @param Request             $request
     * @param string              $hash
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function stakingReport(Request $request, String $hash, SerializerInterface $serializer): Response
    {
        $stakingReport = $this->addressApi->getStakingReport(
            $hash,
            $request->get('period', "daily")
        );

        return new Response($serializer->serialize($stakingReport, 'json'));
    }
}
