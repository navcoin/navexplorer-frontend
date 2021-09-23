<?php

namespace App\Navcoin\CommunityFund\Entity;

class Trend
{
    /** @var int */
    private $start;

    /** @var int */
    private $end;

    /** @var int */
    private $voteYes;

    /** @var int */
    private $voteNo;

    /** @var int */
    private $voteAbstain;

    /** @var int */
    private $voteExclude;

    /** @var int */
    private $trendYes;

    /** @var int */
    private $trendNo;

    /** @var int */
    private $trendAbstain;

    /** @var int */
    private $trendExclude;

    public function __construct(int $start, int $end, int $voteYes, int $voteNo, int $voteAbstain, int $voteExclude, int $trendYes, int $trendNo, int $trendAbstain, int $trendExclude)
    {
        $this->start = $start;
        $this->end = $end;
        $this->voteYes = $voteYes;
        $this->voteNo = $voteNo;
        $this->voteAbstain = $voteAbstain;
        $this->voteExclude = $voteExclude;
        $this->trendYes = $trendYes;
        $this->trendNo = $trendNo;
        $this->trendAbstain = $trendAbstain;
        $this->trendExclude = $trendExclude;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function getVoteAbstain(): int
    {
        return $this->voteAbstain;
    }

    public function getVoteNo(): int
    {
        return $this->voteNo;
    }
    public function getVoteYes(): int
    {
        return $this->voteYes;
    }

    public function getVoteExclude(): int
    {
        return $this->voteExclude;
    }

    public function getTrendYes(): int
    {
        return $this->trendYes;
    }

    public function getTrendNo(): int
    {
        return $this->trendNo;
    }

    public function getTrendAbstain(): int
    {
        return $this->trendAbstain;
    }

    public function getTrendExclude(): int
    {
        return $this->trendExclude;
    }
}
