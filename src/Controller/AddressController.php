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
use Tuupola\Base58;

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
     * @Route("/address/cold/{hash}")
     */
    public function cold(Request $request, String $hash): Response
    {
        try {
            if (strlen($hash) == 61) {
                $coldStaking = "V1";
            } elseif (strlen($hash) == 89) {
                $coldStaking = "V2";
            }

            $version = 53;
            $coldStakingV1 = 21;
            $coldStakingV2 = 36;

            if ($this->getParameter('navcoin.network') != 'mainnet') {
                $version = 111;
                $coldStakingV1 = 8;
                $coldStakingV2 = 32;
            }

            $coldStakingVersion = $coldStakingV1;
            if ($coldStaking == "V2") {
                $coldStakingVersion = $coldStakingV2;
            }

            $base58 = new Base58([
                "characters" => Base58::BITCOIN,
                "check" => true,
                "version" => $coldStakingVersion
            ]);

            $base58_nav = new Base58([
                "characters" => Base58::BITCOIN,
                "check" => true,
                "version" => $version
            ]);

            $decoded = $base58->decode($hash);

            $addresses = str_split($decoded, 20);

            for ($i = 0; $i < count($addresses); $i++) {
                $addresses[$i] = $base58_nav->encode($addresses[$i]);
            }
        } catch (\Exception $e) {
            return $this->render('address/not_valid.html.twig', ['hash' => $hash]);
        }

        return $this->render('address/cold.html.twig', [
            'hash' => $hash,
            'addresses' => $addresses,
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
