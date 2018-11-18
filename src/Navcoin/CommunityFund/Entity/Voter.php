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
    private $votes;

    /**
     * @var bool
     */
    private $vote;

    public function __construct(string $address, int $votes, bool $vote)
    {
        $this->address = $address;
        $this->votes = $votes;
        $this->vote = $vote;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function isVote(): bool
    {
        return $this->vote;
    }
}
