<?php

namespace App\Navcoin\CommunityFund\Entity;

class Proposal
{
    /**
     * @var int
     */
    private $version;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $blockHash;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $requestedAmount;

    /**
     * @var float
     */
    private $notYetPaid;

    /**
     * @var float
     */
    private $userPaidFee;

    /**
     * @var string
     */
    private $paymentAddress;

    /**
     * @var int
     */
    private $proposalDuration;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $stateChangedOnBlock;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $expiresOn;

    /** @var int */
    private $votesYes;
    /** @var int */
    private $votesAbs;
    /** @var int */
    private $votesNo;
    /** @var int */
    private $votingCycle;

    public function __construct(
        int $version,
        string $hash,
        string $blockHash,
        int $height,
        string $description,
        float $requestedAmount,
        float $notYetPaid,
        float $userPaidFee,
        string $paymentAddress,
        int $proposalDuration,
        string $state,
        ?string $stateChangedOnBlock,
        string $status,
        int $votesYes,
        int $votesAbs,
        int $votesNo,
        int $votingCycle
    ) {
        $this->version = $version;
        $this->hash = $hash;
        $this->blockHash = $blockHash;
        $this->height = $height;
        $this->description = $description;
        $this->requestedAmount = $requestedAmount;
        $this->notYetPaid = $notYetPaid;
        $this->userPaidFee = $userPaidFee;
        $this->paymentAddress = $paymentAddress;
        $this->proposalDuration = $proposalDuration;
        $this->state = $state;
        $this->stateChangedOnBlock = $stateChangedOnBlock;
        $this->status = $status;
        $this->votesYes = $votesYes;
        $this->votesAbs = $votesAbs;
        $this->votesNo = $votesNo;
        $this->votingCycle = $votingCycle;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRequestedAmount(): float
    {
        return $this->requestedAmount;
    }

    public function getNotYetPaid(): float
    {
        return $this->notYetPaid;
    }

    public function getUserPaidFee(): float
    {
        return $this->userPaidFee;
    }

    public function getPaymentAddress(): string
    {
        return $this->paymentAddress;
    }

    public function getProposalDuration(): int
    {
        return $this->proposalDuration;
    }

    public function getDuration(): string
    {
        $inputSeconds = $this->proposalDuration;

        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;
        $secondsInAWeek   = 7 * $secondsInADay;
        $secondsInAYear   = 52 * $secondsInAWeek;

        // extract years
        $years = floor($inputSeconds / $secondsInAYear);

        // extract months
        $monthSeconds = $inputSeconds % $secondsInAYear;
        $weeks = floor($monthSeconds / $secondsInAWeek);

        // extract days
        $daySeconds = $inputSeconds % $secondsInAWeek;
        $days = floor($daySeconds / $secondsInADay);

        // extract hours
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        // extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        // extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        $date = "";
        $date .= $years ? $years . ($years == 1 ? ' year, ' : ' years, ') : '';
        $date .= $weeks ? $weeks . ($weeks == 1 ? ' week, ' : ' weeks, ') : '';
        $date .= $days ? $days . ($days == 1 ? ' day, ' : ' days, ') : '';
        $date .= $hours ? $hours . ($hours == 1 ? ' hour, ' : ' hours, ') : '';
        $date .= $minutes ? $minutes . ($minutes == 1 ? ' minute, ' : ' minutes, ') : '';
        $date .= $seconds ? $seconds . ($seconds == 1 ? ' second, ' : ' seconds, ') : '';

        $date = trim($date, ', ');
//        $date = strrev(implode(strrev(' and '), explode(strrev(', '), strrev($date), 2)));
        return $date;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStateChangedOnBlock(): ?string
    {
        return $this->stateChangedOnBlock;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getExpiresOn(): ?\DateTime
    {
        return $this->expiresOn;
    }

    public function setExpiresOn(\DateTime $expiresOn): self
    {
        $this->expiresOn = $expiresOn;

        return $this;
    }

    public function getVotesYes(): int
    {
        return $this->votesYes;
    }

    public function getVotesAbs(): int
    {
        return $this->votesAbs;
    }

    public function getVotesNo(): int
    {
        return $this->votesNo;
    }

    public function getVotingCycle(): int
    {
        return $this->votingCycle;
    }
}