<?php

namespace App\Controller;

use App\CoinGecko\Api as CoinGeckoApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MarketController extends AbstractController
{
    /**
     * @Route("/market/chart/{currency}/{days}.json")
     */
    public function chart(Request $request, SerializerInterface $serializer, CoinGeckoApi $coinGeckoApi)
    {
        $response = $coinGeckoApi->getMarketChart($request->get('currency'), $request->get('days'));
        $btcResponse = $coinGeckoApi->getMarketChart('btc', $request->get('days'));

        foreach ($response['prices'] as $key => $price) {
            $time = strtotime("0:00",intval(floor($price[0]/1000)));
            $prices[$time] = [
                'time' => $time,
                'usd' => $this->getParameter('navcoin.network') == "MAINNET" ? $price[1] : 0,
                'btc' => $this->getParameter('navcoin.network') == "MAINNET" ? $btcResponse['prices'][$key][1] * 100000000 : 0,
            ];
        }

        return new Response($serializer->serialize(array_values($prices), 'json'));
    }
}
