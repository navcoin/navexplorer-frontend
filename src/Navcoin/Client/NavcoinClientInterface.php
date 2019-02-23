<?php

namespace App\Navcoin\Client;

use App\Navcoin\Common\Entity\IteratorEntityInterface;
use Psr\Http\Message\ResponseInterface;

interface NavcoinClientInterface
{
    public function get(string $uri): ResponseInterface;
    public function getBody(ResponseInterface $response): string;
    public function getJsonBody(ResponseInterface $response, bool $assoc = true): array;
    public function getPaginator(ResponseInterface $response): IteratorEntityInterface;
}
