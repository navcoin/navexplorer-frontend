<?php

namespace App\Navcoin\CommunityFund\Entity;

use JMS\Serializer\Serializer;

class Trend
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
    private $segment;

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
    private $blocksCounted;

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

    public function __construct(int $votesYes, int $votesNo, int $segment, int $start, int $end, int $blocksCounted)
    {
        $this->votesYes = $votesYes;
        $this->votesNo = $votesNo;
        $totalVotes = $votesYes + $votesNo;
        $this->segment = $segment;
        $this->start = $start;
        $this->end = $end;
        $this->blocksCounted = $blocksCounted;

        $this->trendYes = round($this->blocksCounted ? ($this->votesYes / $this->blocksCounted) * 100 : 0, 2);
        $this->trendNo = round($this->blocksCounted ? ($this->votesNo / $this->blocksCounted) * 100 : 0, 2);
        $this->trendAbstain = round($this->blocksCounted ? ((($this->blocksCounted - $totalVotes) / $this->blocksCounted) * 100) : 0, 2);
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
}
