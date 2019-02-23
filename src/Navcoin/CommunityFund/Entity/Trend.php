<?php

namespace App\Navcoin\CommunityFund\Entity;

class Trend
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
    private $votesYes;

    /**
     * @var int
     */
    private $votesNo;

    /**
     * @var int
     */
    private $trendYes;

    /**
     * @var int
     */
    private $trendNo;

    /**
     * @var int
     */
    private $trendAbstain;

    public function __construct(int $start, int $end, int $votesYes, int $votesNo, int $trendYes, int $trendNo, int $trendAbstain)
    {
        $this->start = $start;
        $this->end = $end;
        $this->votesYes = $votesYes;
        $this->votesNo = $votesNo;
        $this->trendYes = $trendYes;
        $this->trendNo = $trendNo;
        $this->trendAbstain = $trendAbstain;
    }

    public function getVotesYes(): int
    {
        return $this->votesYes;
    }

    public function getVotesNo(): int
    {
        return $this->votesNo;
    }

    public function getSegment(): int
    {
        return $this->segment;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function getBlocksCounted(): int
    {
        return $this->blocksCounted;
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
}
