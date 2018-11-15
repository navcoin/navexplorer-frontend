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
            $data = $this->getClient()->get('/api/soft-fork');
        } catch (ServerRequestException $e) {
            return new SoftForks();
        }

        return $this->getMapper()->mapIterator($data, SoftForks::class);
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
