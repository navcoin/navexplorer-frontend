<?php

namespace App\Controller;

use App\CoinGecko\Api as CoinGeckoApi;
use App\Exception\DistributionException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Block\Api\BlockGroupApi;
use App\Navcoin\Common\Network;
use App\Navcoin\Distribution\Api\DistributionApi;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /** @var BlockGroupApi */
    private $blockGroupApi;

    /** @var BlockApi */
    private $blockApi;

    public function __construct(BlockGroupApi $blockGroupApi, BlockApi $blockApi)
    {
        $this->blockGroupApi = $blockGroupApi;
        $this->blockApi = $blockApi;
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function index(): array
    {
        return [
            'best' => $this->blockApi->getBestBlock(),
        ];
    }

    /**
     * @Route("/ticker.json")
     */
    public  function ticker(SerializerInterface $serializer, CoinGeckoApi $coinApi, DistributionApi $distributionApi): Response
    {
        $ticker = $coinApi->getTicker();
        try {
            $totalSupply = $distributionApi->getTotalSupply();
        } catch (DistributionException $e) {
            $totalSupply = ['public' => 0, 'private' => 0];
        }
        
        if ($this->getParameter('navcoin.network') != "MAINNET") {
            $ticker['market_data']['current_price']['btc'] = 0;
            $ticker['market_data']['current_price']['usd'] = 0;
        }

        $response = [
            'btc' => $ticker['market_data']['current_price']['btc'],
            'usd' => $ticker['market_data']['current_price']['usd'],
            'marketCap' => floor(($totalSupply['public']+$totalSupply['private'])*$ticker['market_data']['current_price']['usd']),
            'circulatingSupply' => $totalSupply['public'],
            'privateSupply' => $totalSupply['private'],
        ];

        return new Response($serializer->serialize($response, 'json'));
    }

    /**
     * @Route("/network/{network}")
     * @Template()
     */
    public function network(Request $request, Session $session): RedirectResponse
    {
        $network = $request->get('network');
        switch ($network) {
            case 'testnet':
                $network = Network::TEST_NET;
                break;
            default:
                $network = Network::MAIN_NET;
        }

        $session->set('network', $network);

        return $this->redirectToRoute('app_home_index');
    }
}
