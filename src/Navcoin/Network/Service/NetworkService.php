<?php

namespace App\Navcoin\Network\Service;

class NetworkService
{
    /** @var string */
    private $network;

    public function __construct(string $network)
    {
        $this->network = $network;
    }

    public function isMainNet(): bool
    {
        return $this->network == "MAINNET";
    }

    public function isTestNet(): bool
    {
        return $this->network == "TESTNET";
    }
}
