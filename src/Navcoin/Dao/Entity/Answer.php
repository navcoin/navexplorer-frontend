<?php

namespace App\Navcoin\Dao\Entity;

class Answer
{
    /** @var int */
    private $version;

    /** @var string */
    private $answer;

    /** @var int */
    private $support;

    /** @var string */
    private $status;

    /** @var bool */
    private $foundSupport;

    /** @var string */
    private $stateChangedOnBlock;

    /** @var string */
    private $txblockhash;

    /** @var string */
    private $parent;

    /** @var string */
    private $hash;

    public function __construct(
        int $version,
        string $answer,
        int $support,
        string $status,
        bool $foundSupport,
        string $stateChangedOnBlock,
        string $txblockhash,
        string $parent,
        string $hash
    ) {
        $this->version = $version;
        $this->answer = $answer;
        $this->support = $support;
        $this->status = $status;
        $this->foundSupport = $foundSupport;
        $this->stateChangedOnBlock = $stateChangedOnBlock;
        $this->txblockhash = $txblockhash;
        $this->parent = $parent;
        $this->hash = $hash;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getSupport(): int
    {
        return $this->support;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function hasFoundSupport(): bool
    {
        return $this->foundSupport;
    }

    public function getStateChangedOnBlock(): string
    {
        return $this->stateChangedOnBlock;
    }

    public function getTxblockhash(): string
    {
        return $this->txblockhash;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}