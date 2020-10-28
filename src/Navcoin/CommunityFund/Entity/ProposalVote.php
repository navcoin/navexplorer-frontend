<?php

namespace App\Navcoin\CommunityFund\Entity;

class ProposalVote
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $end;

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

    public function __construct(int $start, int $end, int $cycle, int $yes, int $no, int $abstain)
    {
        $this->start = $start;
        $this->end = $end;
        $this->cycle = $cycle;
        $this->yes = $yes;
        $this->no = $no;
        $this->abstain = $abstain;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
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

    public function getTotal(): int
    {
        return $this->yes + $this->no;
    }

    public function getAbstain(): int
    {
        return $this->abstain;
    }
}
