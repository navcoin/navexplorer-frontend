<?php

namespace App\Navcoin\CommunityFund\Entity;

class VoterAddress
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $yes;

    /**
     * @var int
     */
    private $no;

    /**
     * @var int
     */
    private $abstain;

    public function __construct(string $address, int $yes, int $no, int $abstain)
    {
        $this->address = $address;
        $this->yes = $yes;
        $this->no = $no;
        $this->abstain = $abstain;
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
}
