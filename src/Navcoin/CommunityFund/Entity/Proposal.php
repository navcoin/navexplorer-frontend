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
     * @var int
     */
    private $votesYes;

    /**
     * @var int
     */
    private $votesNo;

    /**
     * @var string
     */
    private $status;

    public function __construct(
        int $version,
        string $hash,
        string $description,
        float $requestedAmount,
        float $notYetPaid,
        float $userPaidFee,
        string $paymentAddress,
        int $proposalDuration,
        int $votesYes,
        int $votesNo,
        string $status
    ) {
        $this->version = $version;
        $this->hash = $hash;
        $this->description = $description;
        $this->requestedAmount = $requestedAmount;
        $this->notYetPaid = $notYetPaid;
        $this->userPaidFee = $userPaidFee;
        $this->paymentAddress = $paymentAddress;
        $this->proposalDuration = $proposalDuration;
        $this->votesYes = $votesYes;
        $this->votesNo = $votesNo;
        $this->status = $status;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getHash(): string
    {
        return $this->hash;
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

    public function getStatus(): string
    {
        return $this->status;
    }
}
