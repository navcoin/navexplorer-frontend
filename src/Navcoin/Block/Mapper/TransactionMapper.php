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
            $data['hash'],
            $data['height'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['time']),
            $data['stake'] / 100000000,
            $data['fees'] / 100000000,
            $this->mapInputs($data['vin']),
            $this->mapOutputs($data['vout']),
            $data['type'],
            array_key_exists('raw', $data)  && $data['raw'] ? $data['raw'] : '',
        );

        return $transaction;
    }

    private function mapInputs(array $data): Inputs
    {
        $inputs = new Inputs();

        foreach ($data as $key => $inputData) {
            $inputs->add(
                new Input(
                    array_key_exists('addresses', $inputData) ? $inputData['addresses'] : (array_key_exists('address', $inputData) ? [$inputData['address']] : []),
                    $this->getData('value', $inputData, 0),
                    $key,
                    $this->getData('txid', $inputData, ''),
                    $inputData['previousOutput']['height']
                )
            );
        }

        return $inputs;
    }

    private function mapOutputs(array $data): Outputs
    {
        $outputs = new Outputs();
        foreach ($data as $key => $outputData) {
            if ($outputData['scriptPubKey']['type'] == null) {
                continue;
            }

            try {
                $output = new Output(
                    strtoupper($outputData['scriptPubKey']['type']),
                    $key,
                    $this->getData('valuesat', $outputData, 0),
                    $this->getData('addresses', $outputData['scriptPubKey'], []),
                    $this->hasData('redeemedIn', $outputData) ? $outputData['redeemedIn']['hash'] : null,
                    $this->hasData('redeemedIn', $outputData) ? $outputData['redeemedIn']['height'] : null
                );

                if ($output->isCommunityFund()) {
                    $output->setHash($outputData['scriptPubKey']['hash']);
                }

                $outputs->add($output);
            } catch (\Exception $e) {
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
