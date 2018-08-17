<?php

namespace App\Navcoin\Search\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\Search\Entity\SearchResult;
use App\Navcoin\Search\Exception\SearchResultMissException;

class SearchApi extends NavcoinApi
{
    public function search(String $hash): SearchResult
    {
        try {
             $data = $this->getClient()->get('/api/search/'.$hash);
        } catch (\Exception $e) {
            throw new SearchResultMissException("No results for hash: ".$hash);
        }

        if (array_key_exists('error', $data)) {
            throw new SearchResultMissException($data['message']);
        }

        return new SearchResult($data['type'], $data['value']);
    }
}
