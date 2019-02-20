<?php

namespace App\Navcoin\Block\Entity;

class Output
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $index;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string[]
     */
    private $addresses = [];

    /**
     * @var string
     */
    private $redeemedInTransaction;

    /**
     * @var int
     */
    private $redeemedInBlock;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var bool
     */
    private $proposalVote;

    public function __construct(string $type, int $index, float $amount, array $addresses, ?string $redeemedInTransaction, ?int $redeemedInBlock)
    {
        $this->type = $type;
        $this->index = $index;
        $this->amount = $amount != 0 ? $amount / 100000000 : 0;
        $this->addresses = $addresses;
        $this->redeemedInTransaction = $redeemedInTransaction;
        $this->redeemedInBlock = $redeemedInBlock;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAddress(): ?string
    {
        if (count($this->addresses) == 0) {
            return null;
        }

        return $this->addresses[0];
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getRedeemedInTransaction(): ?string
    {
        return $this->redeemedInTransaction;
    }

    public function getRedeemedInBlock(): ?int
    {
        return $this->redeemedInBlock;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getProposalVote(): ?bool
    {
        switch (true) {
            case $this->getType() == 'PROPOSAL_YES_VOTE':
                return true;
            case $this->getType() == 'PROPOSAL_NO_VOTE':
                return false;
            default:
                return null;
        }
    }

    public function isCommunityFund(): bool
    {
        return in_array($this->getType(), ['PROPOSAL_YES_VOTE', 'PROPOSAL_NO_VOTE', 'PAYMENT_REQUEST_YES_VOTE', 'PAYMENT_REQUEST_NO_VOTE']);
    }
}
