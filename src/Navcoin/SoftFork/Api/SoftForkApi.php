<?php

namespace App\Navcoin\SoftFork\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\SoftFork\Entity\SoftForks;

/**
 * Class SoftForkApi
 *
 * @package App\Navcoin\SoftFork\Api
 */
class SoftForkApi extends NavcoinApi
{
    /**
     * Get All
     *
     * @return SoftForks
     */
    public function getAll(): SoftForks
    {
        try {
            $data = $this->getClient()->get('/api/soft-fork');
        } catch (ServerRequestException $e) {
            return new SoftForks();
        }

        return $this->getMapper()->mapIterator($data, SoftForks::class);
    }
}