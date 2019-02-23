<?php

namespace App\Navcoin\Search\Api;

use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Search\Entity\SearchResult;
use App\Navcoin\Search\Exception\SearchResultMissException;
use GuzzleHttp\Exception\ClientException;

class SearchApi extends NavcoinApi
{
    public function search(String $hash): SearchResult
    {
        try {
            $response = $this->getClient()->get('/api/search?query=' . $hash);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new SearchResultMissException('No results for hash: ' . $hash);
        }

        return new SearchResult($data['type'], $data['value']);
    }
}
