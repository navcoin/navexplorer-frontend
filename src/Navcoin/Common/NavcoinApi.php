<?php

namespace App\Navcoin\Common;

use App\Navcoin\Client\ClientManager;
use App\Navcoin\Client\NavcoinClient;
use App\Navcoin\Common\Mapper\MapperInterface;

/**
 * Class NavcoinApi
 *
 * @package App\Navcoin\Common
 */
abstract class NavcoinApi
{
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var ClientManager
     */
    private $clientManager;

    /**
     * Constructor
     *
     * @param ClientManager   $clientManager
     * @param MapperInterface $mapper
     */
    public function __construct(ClientManager $clientManager, MapperInterface $mapper = null)
    {
        $this->clientManager = $clientManager;

        if ($mapper !== null) {
            $this->mapper = $mapper;
        }
    }

    /**
     * Get Client
     *
     * @return NavcoinClient
     */
    public function getClient()
    {
        return $this->clientManager->getClient();
    }

    /**
     * Get Mapper
     *
     * @return MapperInterface
     */
    public function getMapper()
    {
        return $this->mapper;
    }


    /**
     * Set Network
     *
     * @param String $network
     *
     * @return $this
     */
    public function useNetwork(String $network)
    {
        switch ($network) {
            case Network::TEST_NET:
                $this->client = $this->clientManager->useNetwork($network);
                break;
            default:
                $this->client = $this->clientManager->useNetwork(Network::MAIN_NET);
        }

        return $this;
    }
}
