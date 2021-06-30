<?php

namespace App\Controller;

use App\Exception\AddressInvalidException;
use App\Exception\AddressNotFoundException;
use App\Exception\StakingReportUnavailableException;
use App\Navcoin\Address\Api\AddressApi;
use App\Navcoin\Address\Api\HistoryApi;
use App\Navcoin\Address\Api\StakingApi;
use App\Navcoin\Address\Api\SummaryApi;
use App\Navcoin\Address\Api\TransactionApi;
use App\Navcoin\Address\Entity\StakingGroups;
use App\Navcoin\Block\Api\BlockApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddressController extends AbstractController
{
    /** @var AddressApi */
    private $addressApi;

    /** @var BlockApi */
    private $blockApi;

    /** @var HistoryApi */
    private $historyApi;

    /** @var SummaryApi */
    private $summaryApi;

    /** @var StakingApi */
    private $stakingApi;

    /** @var TransactionApi */
    private $transactionApi;

    /** @var int */
    private $pageSize = 10;

    public function __construct(AddressApi $addressApi, BlockApi $blockApi, HistoryApi $historyApi, SummaryApi $summaryApi, StakingApi $stakingApi, TransactionApi $transactionApi)
    {
        $this->addressApi = $addressApi;
        $this->blockApi = $blockApi;
        $this->historyApi = $historyApi;
        $this->summaryApi = $summaryApi;
        $this->stakingApi = $stakingApi;
        $this->transactionApi = $transactionApi;
    }

    /**
     * @Route("/addresses")
     * @Template()
     */
    public function addresses(): array
    {
        return [];
    }

    /**
     * @Route("/address/{hash}")
     */
    public function index(Request $request, String $hash): Response
    {
        try {
            $address = $this->addressApi->getAddress($hash);
            $summary = $this->summaryApi->getSummary($hash);
        } catch (AddressNotFoundException $e) {
            return $this->render('address/not_found.html.twig', ['hash' => $hash]);
        } catch (AddressInvalidException $e) {
            return $this->render('address/not_valid.html.twig', ['hash' => $hash]);
        }

        $period = $request->get('period', "daily");

        return $this->render('address/index.html.twig', [
            'address' => $address,
            'summary' => $summary,
            'type' => $request->query->getAlpha('type'),
            'stakingReport' => $this->getStakingReport($hash, $period),
            'period' => $period,
            'activeTab' => $request->get('period') ? 'staking-report' : 'history',
        ]);
    }

    /**
     * @Route("/address/{hash}/history.json")
     */
    public function history(Request $request, String $hash, SerializerInterface $serializer): Response
    {
        $history = $this->historyApi->getAddressHistory(
            $hash,
            $request->get('size', $this->pageSize),
            $request->get('page', 1),
            $request->get('type')
        );

        return new Response($serializer->serialize($history, 'json'), 200, [
            'paginator' => $serializer->serialize($history->getPaginator(), 'json'),
    ]);
    }

    private function getStakingReport(string $hash, string $period): ?StakingGroups
    {
        try {
            /** @var StakingGroups $stakingReport */
            $stakingReport = $this->stakingApi->getStakingReport($hash, $period);
        } catch (StakingReportUnavailableException $e) {
            return null;
        }

        return $stakingReport;
    }
}
