<?php

namespace App\Navcoin\CommunityFund\Entity;

class Voter
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $votesYes;

    /**
     * @var int
     */
    private $votesNo;

    /**
     * @var int
     */
    private $votesAbstain;

    public function __construct(string $address, int $votesYes, int $votesNo, int $votesAbstain)
    {
        $this->address = $address;
        $this->votesYes = $votesYes;
        $this->votesNo = $votesNo;
        $this->votesAbstain = $votesAbstain;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getVotesYes(): int
    {
        return $this->votesYes;
    }

    /**
     * @return int
     */
    public function getVotesNo(): int
    {
        return $this->votesNo;
    }

    /**
     * @return int
     */
    public function getVotesAbstain(): int
    {
        return $this->votesAbstain;
    }

}
