<?php

namespace App\Navcoin\Block\Entity;

class Vout
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

    /** @var bool */
    private $redeemed;

    /** @var int */
    private $redeemedInBlock;

    /** @var string */
    private $hash;

    /** @var bool */
    private $private;

    /** @var bool */
    private $privateFee;

    /** @var string */
    private $tokenId;

    /** @var int */
    private $tokenNftId;

    /** @var MultiSig */
    private $multiSig;

    /** @var bool */
    private $wrapped;

    /** @var string[] */
    private $wrappedAddresses;

    public function __construct(string $type, int $index, float $amount, array $addresses, bool $redeemed, ?string $redeemedInTransaction, ?int $redeemedInBlock, ?string $tokenId, ?int $tokenNftId)
    {
        $this->type = $type;
        $this->index = $index;
        $this->amount = $amount != 0 ? $amount / 100000000 : 0;
        $this->addresses = $addresses;
        $this->redeemed = $redeemed;
        $this->redeemedInTransaction = $redeemedInTransaction;
        $this->redeemedInBlock = $redeemedInBlock;
        $this->tokenId = $tokenId;
        $this->tokenNftId = $tokenNftId;
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

    public function isRedeemed(): bool
    {
        return $this->redeemed;
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

    public function getTokenId(): ?string
    {
        return $this->tokenId;
    }

    public function getTokenNftId(): ?int
    {
        return $this->tokenNftId;
    }

    public function getPrivateType(): ?string
    {
        if (!$this->private) {
            return null;
        }

        if (hexdec($this->tokenId) == 0) {
            return "xNav";
        } elseif($this->tokenNftId == -1 || $this->tokenNftId == null) {
            return "Private Token";
        }
        elseif($this->tokenNftId > -1) {
            return "NFT";
        }
    }

    public function isPrivateFee(): bool
    {
        return $this->privateFee ? true : false;
    }

    public function setPrivateFee(bool $privateFee): void
    {
        $this->privateFee = $privateFee;
    }

    public function isMultiSig(): bool
    {
        return $this->multiSig != null;
    }

    public function getMultiSig(): ?MultiSig
    {
        return $this->multiSig;
    }

    public function setMultiSig(MultiSig $multiSig): void
    {
        $this->multiSig = $multiSig;
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
