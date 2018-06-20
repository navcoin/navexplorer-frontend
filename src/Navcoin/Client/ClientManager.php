<?php

namespace App\Navcoin\Client;

use App\Navcoin\Common\Network;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class ClientManager
 *
 * @package App\Navcoin\Client
 */
class ClientManager
{
    /**
     * @var MainNetClient
     */
    private $mainNet;

    /**
     * @var TestNetClient
     */
    private $testNet;

    /**
     * @var NavcoinClient
     */
    private $activeClient;

    /**
     * @var Session
     */
    private $session;

    /**
     * Constructor
     *
     * @param MainNetClient    $mainNet
     * @param TestNetClient    $testNet
     * @param SessionInterface $session
     */
    public function __construct(MainNetClient $mainNet, TestNetClient $testNet, SessionInterface $session)
    {
        $this->mainNet = $mainNet;
        $this->testNet = $testNet;
        $this->session = $session;

        $this->activeClient = $mainNet;
    }

    /**
     * Get client
     *
     * @return MainNetClient|NavcoinClient
     */
    public function getClient()
    {
        switch ($this->session->get('network')) {
            case Network::MAIN_NET:
                return $this->mainNet;
            case Network::TEST_NET;
                return $this->testNet;
            default:
                return $this->activeClient;
        }
    }

    /**
     * Use network
     *
     * @param String $network
     *
     * @return $this
     */
    public function useNetwork(String $network)
    {
        $this->activeClient = ($network === Network::TEST_NET) ? $this->testNet : $this->mainNet;

        return $this;
    }
}
