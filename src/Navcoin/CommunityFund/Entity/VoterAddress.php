<?php

namespace App\Navcoin\CommunityFund\Entity;

class VoterAddress
{
    /** @var string */
    private $address;

    /** @var int */
    private $yes;

    /** @var int */
    private $no;

    /** @var int */
    private $abstain;

    /** @var int */
    private $exclude;

    public function __construct(string $address, int $yes, int $no, int $abstain, int $exclude)
    {
        $this->address = $address;
        $this->yes = $yes;
        $this->no = $no;
        $this->abstain = $abstain;
        $this->exclude = $exclude;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getYes(): int
    {
        return $this->yes;
    }

    public function getNo(): int
    {
        return $this->no;
    }

    public function getAbstain(): int
    {
        return $this->abstain;
    }

    public function getExclude(): int
    {
        return $this->exclude;
    }
}
