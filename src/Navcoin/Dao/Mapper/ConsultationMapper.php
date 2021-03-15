<?php

namespace App\Navcoin\Dao\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Dao\Entity\Answer;
use App\Navcoin\Dao\Entity\Consultation;;

class ConsultationMapper extends BaseMapper
{
    public function mapEntity(array $data): Consultation
    {
        $consultation = new Consultation(
            $data['version'],
            $data['hash'],
            $data['blockHash'],
            $data['question'],
            $data['support'],
            $this->getData('abstain', $data),
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

        if ($consultation->IsARange()) {
            ksort($data['rangeAnswers']);
            $consultation->setRangeAnswers($this->getData('rangeAnswers', $data, []));
        } else {
            $consultation->setAnswers($this->mapAnswers($this->getData('answers', $data, [])));
        }

        return $consultation;
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
        if ($data != null) {
            foreach ($data as $answer) {
                $answers[] = $this->mapAnswer($answer);
            }
        }

        return $answers;
    }
}