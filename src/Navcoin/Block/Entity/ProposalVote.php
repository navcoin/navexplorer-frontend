<?php

namespace App\Navcoin\Block\Entity;

class ProposalVote
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @var bool
     */
    private $vote;

    public function __construct(string $hash, bool $vote)
    {
        $this->hash = $hash;
        $this->vote = $vote;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function isVote(): bool
    {
        return $this->vote;
    }
}
