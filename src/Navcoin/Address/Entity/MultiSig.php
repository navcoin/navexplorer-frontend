<?php

namespace App\Navcoin\Address\Entity;

class MultiSig
{
    /** @var string */
    private $hash;

    /** @var []string */
    private $signatures;

    /** @var int */
    private $required;

    /** @var int */
    private $total;

    public function __construct(string $hash, $signatures, int $required, int $total)
    {
        $this->hash = $hash;
        $this->signatures = $signatures;
        $this->required = $required;
        $this->total = $total;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getSignatures()
    {
        return $this->signatures;
    }

    public function getRequired(): int
    {
        return $this->required;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getKey(): string {
        return sprintf("%s-%s", $this->hash, join('-', $this->signatures));
    }
}