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

    private function mapAnswers(?array $data): array
    {
        $answers = [];
        foreach($data as $answer) {
            $answers[] = new Answer(
                $answer['version'],
                $answer['answer'],
                $answer['support'],
                $answer['votes'],
                $answer['status'],
                $answer['foundSupport'],
                $answer['stateChangedOnBlock'],
                $answer['txblockhash'],
                $answer['parent'],
                $answer['hash']
            );
        }

        return $answers;
    }
}