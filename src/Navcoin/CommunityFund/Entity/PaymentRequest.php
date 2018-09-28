<?php

namespace App\Navcoin\CommunityFund\Entity;

class PaymentRequest
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
    private $proposalHash;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $requestedAmount;

    /**
     * @var PaymentRequestVotes
     */
    private $paymentRequestVotes;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $approvedOnBlock;

    /**
     * @var string
     */
    private $paidOnBlock;

    public function __construct(
        int $version,
        string $hash,
        string $blockHash,
        string $proposalHash,
        string $description,
        float $requestedAmount,
        PaymentRequestVotes $paymentRequestVotes,
        string $state,
        string $status
    ) {
        $this->version = $version;
        $this->hash = $hash;
        $this->blockHash = $blockHash;
        $this->proposalHash = $proposalHash;
        $this->description = $description;
        $this->requestedAmount = $requestedAmount;
        $this->paymentRequestVotes = $paymentRequestVotes;
        $this->state = $state;
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

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getProposalHash(): string
    {
        return $this->proposalHash;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRequestedAmount(): float
    {
        return $this->requestedAmount;
    }

    public function getPaymentRequestVotes(): PaymentRequestVotes
    {
        return $this->paymentRequestVotes;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getApprovedOnBlock(): string
    {
        return $this->approvedOnBlock;
    }

    public function setApprovedOnBlock(string $approvedOnBlock): self
    {
        $this->approvedOnBlock = $approvedOnBlock;

        return $this;
    }

    public function getPaidOnBlock(): string
    {
        return $this->paidOnBlock;
    }

    public function setPaidOnBlock(string $paidOnBlock): self
    {
        $this->paidOnBlock = $paidOnBlock;

        return $this;
    }
}
