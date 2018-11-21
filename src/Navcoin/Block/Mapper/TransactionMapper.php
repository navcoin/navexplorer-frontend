<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\Input;
use App\Navcoin\Block\Entity\Inputs;
use App\Navcoin\Block\Entity\Output;
use App\Navcoin\Block\Entity\Outputs;
use App\Navcoin\Block\Entity\ProposalVote;
use App\Navcoin\Block\Entity\ProposalVotes;
use App\Navcoin\Block\Entity\Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
        $transaction = new Transaction(
            $data['id'],
            $data['hash'],
            $data['height'],
            (new \DateTime())->setTimestamp($data['time']/1000),
            $data['stake'] / 100000000,
            $data['fees'] / 100000000,
            $this->mapInputs($data['inputs']),
            $this->mapOutputs($data['outputs']),
            $data['type'],
            array_key_exists('raw', $data)  && $data['raw'] ? $data['raw'] : '',
            $this->mapProposalVotes(array_key_exists('proposalVotes', $data) && $data['proposalVotes'] ? $data['proposalVotes'] : [])
        );

        return $transaction;
    }

    private function mapInputs(array $data): Inputs
    {
        $inputs = new Inputs();

        foreach ($data as $inputData) {
            $inputs->add(
                new Input(
                    array_key_exists('addresses', $inputData) ? $inputData['addresses'] : (array_key_exists('address', $inputData) ? [$inputData['address']] : []),
                    $inputData['amount'] / 100000000,
                    $inputData['index'],
                    $inputData['previousOutput'],
                    $inputData['previousOutputBlock']
                )
            );
        }

        return $inputs;
    }

    private function mapOutputs(array $data): Outputs
    {
        $outputs = new Outputs();
        foreach ($data as $outputData) {
            if ($outputData['type'] == null) {
                continue;
            }

            try {
                $output = new Output(
                    $outputData['type'],
                    $outputData['index'],
                    $outputData['amount'] / 100000000,
                    array_key_exists('addresses', $outputData) ? $outputData['addresses'] : (array_key_exists('address', $outputData) ? [$outputData['address']] : []),
                    is_array($outputData['redeemedIn']) ? $outputData['redeemedIn']['hash'] : null,
                    is_array($outputData['redeemedIn']) ? $outputData['redeemedIn']['height'] : null
                );

                if (in_array($output->getType(), ['PROPOSAL_YES_VOTE', 'PROPOSAL_NO_VOTE'])) {
                    $output->setHash($outputData['hash']);
                }

                $outputs->add($output);
            } catch (\Exception $e) {
                //
            }
        }

        return $outputs;
    }

    private function mapProposalVotes(array $data): ProposalVotes
    {
        $proposalVotes = new ProposalVotes();
        foreach ($data as $voteData) {
            $proposalVotes->add(new ProposalVote($voteData['hash'], $voteData['vote']));
        }

        return $proposalVotes;
    }
}
