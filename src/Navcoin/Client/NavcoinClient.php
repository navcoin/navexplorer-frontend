<?php

namespace App\Navcoin\Client;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Entity\Paginator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;

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
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    ];

    public function __construct(string $baseUrl, string $network)
    {
        $this->baseUrl = $baseUrl;
        $this->network = $network;

        $this->client = HttpClientDiscovery::find();
        $this->messageFactory = MessageFactoryDiscovery::find();
    }

    public function get(string $uri): ResponseInterface
    {
        $request = $this->messageFactory
            ->createRequest('GET', $this->baseUrl.$uri, $this->headers)
            ->withHeader("Network", strtolower($this->network));

        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() == 404) {
            throw new ClientException("Resource not found", $request, $response);
        }

        if ($response->getStatusCode() == 500) {
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
