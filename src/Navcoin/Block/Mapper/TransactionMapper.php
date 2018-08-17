<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\Input;
use App\Navcoin\Block\Entity\Inputs;
use App\Navcoin\Block\Entity\Output;
use App\Navcoin\Block\Entity\Outputs;
use App\Navcoin\Block\Entity\Transaction;
use App\Navcoin\Common\Mapper\BaseMapper;

/**
 * Class TransactionMapper
 *
 * @package App\Navcoin\Mapper
 */
class TransactionMapper extends BaseMapper
{
    /**
     * Map transaction
     *
     * @param array $data
     *
     * @return Transaction
     */
    public function mapEntity(array $data): Transaction
    {
        return new Transaction(
            $data['id'],
            $data['hash'],
            $data['height'],
            (new \DateTime())->setTimestamp($data['time']/1000),
            $data['stake'] / 100000000,
            $data['fees'] / 100000000,
            $this->mapInputs($data['inputs']),
            $this->mapOutputs($data['outputs']),
            $data['type'],
            array_key_exists('raw', $data)  && $data['raw'] ? $data['raw'] : ''
        );
    }

    /**
     * Map Inputs
     *
     * @param array $data
     *
     * @return Inputs
     */
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

    /**
     * Map Outputs
     *
     * @param array $data
     *
     * @return Outputs
     */
    private function mapOutputs(array $data): Outputs
    {
        $outputs = new Outputs();

        foreach ($data as $outputData) {
            $outputs->add(
                new Output(
                    $outputData['index'],
                    $outputData['amount'] / 100000000,
                    array_key_exists('addresses', $outputData) ? $outputData['addresses'] : (array_key_exists('address', $outputData) ? [$outputData['address']] : []),
                    $outputData['redeemedIn']['hash'],
                    $outputData['redeemedIn']['height']
                )
            );
        }

        return $outputs;
    }
}
