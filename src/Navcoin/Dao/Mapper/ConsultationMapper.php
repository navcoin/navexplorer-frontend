<?php

namespace App\Navcoin\Dao\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Dao\Entity\Answer;
use App\Navcoin\Dao\Entity\Consultation;;

class ConsultationMapper extends BaseMapper
{
    public function mapEntity(array $data): Consultation
    {
        return new Consultation(
            $data['version'],
            $data['hash'],
            $data['blockHash'],
            $data['question'],
            $data['support'],
            $this->getData('abstain', $data),
            $this->mapAnswers($data['answers']),
            $data['min'],
            $data['max'],
            $data['votingCyclesFromCreation'],
            $data['votingCycleForState'],
            $data['state'],
            $data['status'],
            $data['proposedBy'],
            $data['answerIsARange'],
            $data['moreAnswers'],
            $data['consensusParameter'],
            $this->getData('stateChangedOnBlock', $data),
            $this->getData('height', $data),
            $this->getData('updatedOnBlock', $data)
        );
    }

    public function mapAnswer(array $data): Answer
    {
        return new Answer(
            $data['version'],
            $data['answer'],
            $data['support'],
            $data['votes'],
            $data['status'],
            $data['foundSupport'],
            $data['stateChangedOnBlock'],
            $data['txblockhash'],
            $data['parent'],
            $data['hash']
        );
    }

    private function mapAnswers(?array $data): array
    {
        $answers = [];
        foreach($data as $answer) {
            $answers[] = $this->mapAnswer($answer);
        }

        return $answers;
    }
}