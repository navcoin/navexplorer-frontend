<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\PreviousOutput;
use App\Navcoin\Block\Entity\Vin;
use App\Navcoin\Block\Entity\Vins;
use App\Navcoin\Block\Entity\MultiSig;
use App\Navcoin\Block\Entity\Vout;
use App\Navcoin\Block\Entity\Vouts;
use App\Navcoin\Block\Entity\ProposalVote;
use App\Navcoin\Block\Entity\ProposalVotes;
use App\Navcoin\Block\Entity\Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

class TransactionMapper extends BaseMapper
{
    public function mapEntity(array $data): Transaction
    {
        $script = $this->getData("strdzeel", $data, "[]");
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
            $data['size'],
            $data['version'],
            $this->getData("private", $data, false),
            $this->getData("wrapped", $data, false),
            $script != "" && $script != "[]" && !$this->isVersionScript($script),
        );

        return $transaction;
    }

    private function mapInputs(array $data): Vins
    {
        $inputs = new Vins();

        foreach ($data as $key => $inputData) {
            $inputs->add(new Vin(
                $this->getData('coinbase', $inputData, null),
                $this->getData('txid', $inputData),
                $this->getData('vout', $inputData),
                $this->getData('sequence', $inputData),
                $this->getData('value', $inputData, 0),
                $this->getData('valuesat', $inputData, 0),
                $this->mapPreviousOutput($this->getData('previousOutput', $inputData, [])),
                $this->getData('addresses', $inputData, null),
            ));
        }

        return $inputs;
    }

    private function mapPreviousOutput(array $data): ?PreviousOutput {
        if ($data == null) {
            return null;
        }

        return new PreviousOutput(
            $this->getData('height', $data),
            $this->getData('type', $data),
            $this->mapMultiSig($this->getData('multisig', $data, null)),
            $this->getData('private', $data, false),
            $this->getData('wrapped', $data, false),
        );
    }

    private function mapMultiSig(?array $data): ?MultiSig {
        if ($data == null) {
            return null;
        }

        return new MultiSig(
            $this->getData('hash', $data),
            $this->getData('signatures', $data, []),
            $this->getData('required', $data),
            $this->getData('total', $data),
        );
    }

    private function mapOutputs(array $data): Vouts
    {
        $outputs = new Vouts();
        foreach ($data as $key => $outputData) {
            if ($outputData['scriptPubKey']['type'] == null) {
                continue;
            }

            try {
                $output = new Vout(
                    strtoupper($outputData['scriptPubKey']['type']),
                    $key,
                    $this->getData('valuesat', $outputData, 0),
                    $this->getData('addresses', $outputData['scriptPubKey'], []),
                    $this->getData('redeemed', $outputData, false),
                    $this->hasData('redeemedIn', $outputData) ? $outputData['redeemedIn']['hash'] : null,
                    $this->hasData('redeemedIn', $outputData) ? $outputData['redeemedIn']['height'] : null,
                    $this->hasData('tokenId', $outputData) ? $outputData['tokenId'] : null,
                    $this->hasData('tokenNftId', $outputData) ? $outputData['tokenNftId'] : null,
                );

                if ($this->hasData("multisig", $outputData)) {
                    $multisig = $outputData['multisig'];
                    $output->setMultiSig(new MultiSig($multisig['hash'], $multisig['signatures'], $multisig['required'], $multisig['total']));
                }

                if ($this->hasData('scriptPubKey', $outputData)) {
                    if ($this->hasData('hash', $outputData['scriptPubKey'])) {
                        $output->setHash($this->getData('hash', $outputData['scriptPubKey'], null));
                    }
                    if ($this->hasData("wrapped", $outputData)) {
                        $output->setWrapped($this->getData("wrapped", $outputData));
                        $output->setWrappedAddresses($this->getData('wrappedAddresses', $outputData, []));
                    }

                    if (!$output->isWrapped() && $this->hasData('asm', $outputData['scriptPubKey'])) {
                        if ($outputData['scriptPubKey']['asm'] == "OP_RETURN" && $outputData['scriptPubKey']['type'] == "nulldata") {
                            $output->setPrivateFee(true);
                        }

                        if ($outputData['scriptPubKey']['type'] == "nonstandard" && $outputData['scriptPubKey']['asm']) {
                            $output->setPrivate(true);
                        }
                    }
                }

                $outputs->add($output);
            } catch (\Exception $e) {
            }
        }

        return $outputs;
    }

    private function isVersionScript($script): bool {
        return preg_match("/^\;([0-9]*)$/", $script) == 1;
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
