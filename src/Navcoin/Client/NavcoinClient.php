<?php

namespace App\Navcoin\Client;

use GuzzleHttp\Client;

/**
 * Class NavcoinClient
 *
 * @package App\Navcoin
 */
abstract class NavcoinClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor
     *
     * @param String      $baseUri
     * @param Client|null $client
     */
    public function __construct(String $baseUri, Client $client = null)
    {
        $this->client = $client ?: new Client([
            'base_uri' => $baseUri,
        ]);
    }

    /**
     * Get
     *
     * @param string $uri
     *
     * @return array
     */
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
