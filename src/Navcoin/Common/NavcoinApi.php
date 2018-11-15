<?php

namespace App\Navcoin\Common;

use App\Navcoin\Client\NavcoinClientInterface;
use App\Navcoin\Common\Mapper\MapperInterface;

abstract class NavcoinApi
{
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var NavcoinClientInterface
     */
    private $client;

    public function __construct(NavcoinClientInterface $client, MapperInterface $mapper = null)
    {
        $this->client = $client;

        if ($mapper !== null) {
            $this->mapper = $mapper;
        }
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getMapper()
    {
        return $this->mapper;
    }
}
