<?php

namespace App\Navcoin\SoftFork\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\SoftFork\Entity\SoftFork;
use App\Navcoin\SoftFork\Entity\SoftForks;
use App\Navcoin\SoftFork\Exception\SoftForkNotFoundException;

class SoftForkApi extends NavcoinApi
{
    public function getAll(): SoftForks
    {
        try {
            $response = $this->getClient()->get('/api/soft-fork');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            throw new \RuntimeException("Could not load soft forks");
        }

        return $this->getMapper()->mapIterator( SoftForks::class, $data);
    }

    public function getByName(string $name): SoftFork
    {
        foreach ($this->getAll() as $element) {
            if ($element->getName() == $name) {
                return $element;
            }
        }

        throw new SoftForkNotFoundException(sprintf("Could not find soft fork: %s", $name));
    }
}
