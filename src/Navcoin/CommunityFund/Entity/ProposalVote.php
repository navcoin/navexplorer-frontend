<?php

namespace App\Navcoin\CommunityFund\Entity;

class ProposalVote
{
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
    private $votingCycle;

    public function __construct(int $votesYes, int $votesNo, int $votingCycle)
    {
        $this->votesYes = $votesYes;
        $this->votesNo = $votesNo;
        $this->votingCycle = $votingCycle;
    }

    public function getVotesYes(): int
    {
        return $this->votesYes;
    }

    public function getVotesNo(): int
    {
        return $this->votesNo;
    }

    public function getVotesTotal(): int
    {
        return $this->votesYes + $this->votesNo;
    }

    public function getVotingCycle(): int
    {
        return $this->votingCycle;
    }
}
