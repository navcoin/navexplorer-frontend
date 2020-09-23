<?php

namespace App\Navcoin\Address\Entity;

use DateTime;

class Summary
{
    /** @var int */
    protected $height;

    /** @var string */
    private $hash;

    /** @var Balance */
    private $balance;

    public function __construct(int $height, string $hash, Balance $balance)
    {
        $this->height = $height;
        $this->hash = $hash;
        $this->balance = $balance;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }
}