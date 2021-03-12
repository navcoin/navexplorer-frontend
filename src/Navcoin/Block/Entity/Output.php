<?php

namespace App\Navcoin\Block\Entity;

class Output
{
    /** @var string */
    private $type;

    /** @var int */
    private $index;

    /** @var float */
    private $amount;

    /** @var string[] */
    private $addresses = [];

    /** @var string */
    private $redeemedInTransaction;

    /** @var int */
    private $redeemedInBlock;

    /** @var string */
    private $hash;

    /** @var bool */
    private $private;

    /** @var bool */
    private $privateFee;

    /** @var bool */
    private $wrapped;

    /** @var string[] */
    private $wrappedAddresses;

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

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function isPrivate(): bool
    {
        return $this->private ? true : false;
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    public function isPrivateFee(): bool
    {
        return $this->privateFee ? true : false;
    }

    public function setPrivateFee(bool $privateFee): void
    {
        $this->privateFee = $privateFee;
    }

    public function isWrapped(): bool
    {
        return $this->wrapped;
    }

    public function setWrapped(bool $wrapped): void
    {
        $this->wrapped = $wrapped;
    }

    public function getWrappedAddresses(): array
    {
        return $this->wrappedAddresses;
    }

    public function setWrappedAddresses(array $wrappedAddresses): void
    {
        $this->wrappedAddresses = $wrappedAddresses;
    }

    public function isCommunityFund(): bool
    {
        return in_array($this->getType(), ['PROPOSAL_YES_VOTE', 'PROPOSAL_NO_VOTE', 'PAYMENT_REQUEST_YES_VOTE', 'PAYMENT_REQUEST_NO_VOTE']);
    }

    public function isProposalVote(): bool
    {
        return in_array($this->getType(), ['PROPOSAL_YES_VOTE', 'PROPOSAL_NO_VOTE', 'PROPOSAL_ABSTAIN_VOTE', 'PROPOSAL_REMOVE_VOTE']);
    }

    public function isPaymentRequestVote(): bool
    {
        return in_array($this->getType(), ['PAYMENT_REQUEST_YES_VOTE', 'PAYMENT_REQUEST_NO_VOTE', 'PAYMENT_REQUEST_ABSTAIN_VOTE', 'PAYMENT_REQUEST_REMOVE_VOTE']);
    }

    public function isConsultationVote(): bool
    {
        return in_array($this->getType(), ['CONSULTATION_VOTE', 'CONSULTATION_VOTE_REMOVE', 'CONSULTATION_VOTE_ABSTENTION', 'DAO_SUPPORT', 'DAO_SUPPORT_REMOVE']);
    }

    public function isSupportVote(): bool
    {
        return in_array($this->getType(), ['DAO_SUPPORT', 'DAO_SUPPORT_REMOVE']);
    }
}
