<?php

namespace App\Navcoin\Dao\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Dao\Entity\ConsensusParameter;
use App\Navcoin\Dao\Entity\ConsensusParameters;

class ConsensusParameterMapper extends BaseMapper
{
    public function mapAll(array $data): ConsensusParameters
    {
        $parameters = [];
        foreach($data as $key => $value) {
            $parameters[] = $this->mapEntity($value);
        }
        $consensusParameters = new ConsensusParameters();
        $consensusParameters->setElements($parameters);

        return $consensusParameters;
    }

    public function mapEntity(array $data): ConsensusParameter
    {
        return new ConsensusParameter(
            $data['id'],
            $data['desc'],
            $data['type'],
            $data['value'],
            $data['updatedOnBlock']
        );
    }
}