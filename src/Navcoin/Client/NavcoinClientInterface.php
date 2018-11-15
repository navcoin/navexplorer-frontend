<?php

namespace App\Navcoin\Client;

interface NavcoinClientInterface
{
    public function get(string $uri): array;
}
