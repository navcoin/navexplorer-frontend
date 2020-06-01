<?php

namespace App\Navcoin\Dao\Entity;

class Consultation
{
    /** @var int */
    private $version;

    /** @var string */
    private $hash;

    /** @var string */
    private $blockHash;

    /** @var string */
    private $question;

    /** @var int */
    private $support;

    /** @var int */
    private $abstain;

    /** @var Answer[] */
    private $answers;

    /** @var int */
    private $min;

    /** @var int */
    private $max;

    /** @var int */
    private $votingCyclesFromCreation;

    /** @var int */
    private $votingCycleForState;

    /** @var int */
    private $state;

    /** @var string */
    private $status;

    /** @var string */
    private $proposedBy;

    /** @var bool */
    private $answerIsARange;

    /** @var bool */
    private $moreAnswers;

    /** @var bool */
    private $consensusParameter;

    /** @var string */
    private $stateChangedOnBlock;

    /** @var int */
    private $height;

    /** @var int */
    private $updatedOnBlock;

    public function __construct(
        int $version,
        string $hash,
        string $blockHash,
        string $question,
        int $support,
        ?int $abstain,
        array $answers,
        int $min,
        int $max,
        int $votingCyclesFromCreation,
        int $votingCycleForState,
        int $state,
        string $status,
        string $proposedBy,
        bool $answerIsARange,
        bool $moreAnswers,
        bool $consensusParameter,
        string $stateChangedOnBlock,
        ?int $height,
        ?int $updatedOnBlock
    ) {
        $this->version = $version;
        $this->hash = $hash;
        $this->blockHash = $blockHash;
        $this->question = $question;
        $this->support = $support;
        $this->abstain = $abstain;
        $this->answers = $answers;
        $this->min = $min;
        $this->max = $max;
        $this->votingCyclesFromCreation = $votingCyclesFromCreation;
        $this->votingCycleForState = $votingCycleForState;
        $this->state = $state;
        $this->status = $status;
        $this->stateChangedOnBlock = $stateChangedOnBlock;
        $this->proposedBy = $proposedBy;
        $this->answerIsARange = $answerIsARange;
        $this->moreAnswers = $moreAnswers;
        $this->consensusParameter = $consensusParameter;
        $this->height = $height;
        $this->updatedOnBlock = $updatedOnBlock;
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

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getSupport(): int
    {
        return $this->support;
    }

    public function getAbstain(): ?int
    {
        return $this->abstain;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function getAnswer(string $hash): ?Answer
    {
        foreach ($this->answers as $answer) {
            if ($answer->getHash() == $hash) {
                return $answer;
            }
        }

        return null;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getVotingCyclesFromCreation(): int
    {
        return $this->votingCyclesFromCreation;
    }

    public function getVotingCycleForState(): int
    {
        return $this->votingCycleForState;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getProposedBy(): string
    {
        return $this->proposedBy;
    }

    public function IsARange(): bool
    {
        return $this->answerIsARange;
    }

    public function allowsMoreAnswers(): bool
    {
        return $this->moreAnswers;
    }

    public function isConsensusParameter(): bool
    {
        return $this->consensusParameter;
    }

    public function getStateChangedOnBlock(): string
    {
        return $this->stateChangedOnBlock;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getUpdatedOnBlock(): int
    {
        return $this->updatedOnBlock;
    }

    public function getAcceptedAnswer(): ?Answer
    {
        foreach($this->getAnswers() as $answer) {
            if ($answer->getStatus() == 'passed') {
                return $answer;
            }
        }

        return null;
    }
}
