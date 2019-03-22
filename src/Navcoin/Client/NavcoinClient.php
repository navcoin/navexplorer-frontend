<?php

namespace App\Navcoin\Client;

use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class NavcoinClient implements NavcoinClientInterface
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $network;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var \Http\Message\MessageFactory
     */
    private $messageFactory;

    /**
     * @var array
     */
    private $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function __construct(string $baseUrl, string $network, LoggerInterface $logger)
    {
        $this->baseUrl = $baseUrl;
        $this->network = strtolower($network);
        $this->logger = $logger;

        $this->client = HttpClientDiscovery::find();
        $this->messageFactory = MessageFactoryDiscovery::find();
    }

    public function get(string $uri): ResponseInterface
    {
        $this->headers["Network"] = $this->network;

        $this->logger->debug("Api Request:", [$this->network, $this->baseUrl.$uri, $this->headers]);
        $request = $this->messageFactory->createRequest('GET', $this->baseUrl.$uri, $this->headers);

        $response = $this->client->sendRequest($request);
        $this->logger->debug("Api Response:", [$response->getStatusCode(), $response]);

        switch ($response->getStatusCode()) {
            case 400:
                throw new ClientException("Request not valid", $request, $response);
            case 404:
                throw new ClientException("Resource not found", $request, $response);
            case 500:
                throw new ClientException($response->getBody()->getContents(), $request, $response);
        }

        return $response;
    }

    public function getBody(ResponseInterface $response): string
    {
        return $response->getBody()->getContents();
    }

    public function getJsonBody(ResponseInterface $response, bool $assoc = true): array
    {
        $jsonBody = \GuzzleHttp\json_decode($this->getBody($response), $assoc);
        if ($jsonBody == null) {
            return [];
        }

        return $jsonBody;
    }

    public function getPaginator(ResponseInterface $response): IteratorEntityInterface
    {
        if ($response->hasHeader('x-pagination')) {
            $data = \GuzzleHttp\json_decode($response->getHeader('x-pagination')[0], true);

            return (new Paginator())
                ->setFirst($data['first'])
                ->setLast($data['last'])
                ->setTotalElements($data['total'])
                ->setSize($data['size'])
                ->setTotalPages($data['total_pages'])
                ->setNumberOfElements($data['number_of_elements']);
        }

        return null;
    }
}
