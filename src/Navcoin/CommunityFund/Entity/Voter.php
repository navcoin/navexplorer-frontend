<?php

namespace App\Navcoin\CommunityFund\Entity;

class Voter
{
    /**
     * @var int
     */
    private $cycle;

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

    /**
     * @var VoterAddress[]
     */
    private $addresses;

    public function __construct(int $cycle, int $yes, int $no, int $abstain)
    {
        $this->cycle = $cycle;
        $this->yes = $yes;
        $this->no = $no;
        $this->abstain = $abstain;
    }

    public function getCycle(): int
    {
        return $this->cycle;
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

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function setAddresses(array $addresses)
    {
        $this->addresses = $addresses;
    }
}
