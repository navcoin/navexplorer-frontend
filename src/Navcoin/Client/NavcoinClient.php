<?php

namespace App\Navcoin\Client;

use GuzzleHttp\Client;

class NavcoinClient implements NavcoinClientInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(String $baseUri, Client $client = null)
    {
        $this->client = $client ?: new Client([
            'base_uri' => $baseUri,
        ]);
    }

    public function get(string $uri): array
    {
        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
