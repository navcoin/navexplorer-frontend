<?php


namespace App\CoinGecko;


use App\Exception\AddressIndexIncompleteException;
use App\Exception\ServerRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class Api
{
    /** @var string */
    private $baseUrl;

    /** @var Client */
    private $client;

    /** @var \Http\Message\MessageFactory */
    private $messageFactory;

    /** @var FilesystemAdapter */
    private $cache;

    /** @var array */
    private $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function __construct()
    {
        $this->baseUrl = "https://api.coingecko.com/api/v3";
        $this->client = HttpClientDiscovery::find();
        $this->messageFactory = MessageFactoryDiscovery::find();
        $this->cache = new FilesystemAdapter();
    }

    public function getTicker(): array
    {
        try {
            return $this->cache->get('CoinGecko-Ticker', function (ItemInterface $item) {
                $item->expiresAfter(60);
                return $this->getJsonBody($this->get('/coins/nav-coin'));
            });
        } catch (ServerRequestException $e) {
            throw $e;
        }
    }

    private function get(string $uri): ResponseInterface
    {
        $request = $this->messageFactory->createRequest('GET', $this->baseUrl.$uri, $this->headers);

        $response = $this->client->sendRequest($request);

        switch ($response->getStatusCode()) {
            case 400:
                throw new ClientException($response->getBody()->getContents(), $request, $response);
            case 404:
                throw new ClientException("Resource not found", $request, $response);
            case 500:
                throw new ClientException($response->getBody()->getContents(), $request, $response);
        }

        return $response;
    }

    private function getBody(ResponseInterface $response): string
    {
        return $response->getBody()->getContents();
    }

    private function getJsonBody(ResponseInterface $response, bool $assoc = true): array
    {
        $jsonBody = \GuzzleHttp\json_decode($this->getBody($response), $assoc);
        if ($jsonBody == null) {
            return [];
        }

        return $jsonBody;
    }
}