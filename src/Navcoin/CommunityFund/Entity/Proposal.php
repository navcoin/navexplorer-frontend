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
     * @var ProposalVotes
     */
    private $proposalVotes;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $approvedOnBlock;

    /**
     * @var \DateTime
     */
    private $expiresOn;

    public function __construct(
        int $version,
        string $hash,
        string $blockHash,
        string $description,
        float $requestedAmount,
        float $notYetPaid,
        float $userPaidFee,
        string $paymentAddress,
        int $proposalDuration,
        ProposalVotes $proposalVotes,
        string $state,
        string $status,
        \DateTime $createdAt
    ) {
        $this->version = $version;
        $this->hash = $hash;
        $this->blockHash = $blockHash;
        $this->description = $description;
        $this->requestedAmount = $requestedAmount;
        $this->notYetPaid = $notYetPaid;
        $this->userPaidFee = $userPaidFee;
        $this->paymentAddress = $paymentAddress;
        $this->proposalDuration = $proposalDuration;
        $this->proposalVotes = $proposalVotes;
        $this->state = $state;
        $this->status = $status;
        $this->createdAt = $createdAt;
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

    public function getProposalVotes(): ProposalVotes
    {
        return $this->proposalVotes;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getApprovedOnBlock(): ?string
    {
        return $this->approvedOnBlock;
    }

    public function setApprovedOnBlock(string $approvedOnBlock): self
    {
        $this->approvedOnBlock = $approvedOnBlock;

        return $this;
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

    public function wasApproved(): bool
    {
        return $this->approvedOnBlock != null;
    }
}