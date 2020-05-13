<?php

namespace App\Navcoin\Dao\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Dao\Entity\ConsensusParameter;
use App\Navcoin\Dao\Entity\ConsensusParameters;

class ConsensusParameterMapper extends BaseMapper
{
    public function mapEntity(array $data): ConsensusParameters
    {
        $parameters = [];

        foreach($data as $key => $value) {
            $parameters[] =  new ConsensusParameter(
                $value['id'],
                $value['desc'],
                $value['type'],
                $value['value'],
                $value['updatedOnBlock']
            );
        }
        $consensusParameters = new ConsensusParameters();
        $consensusParameters->setElements($parameters);

        return $consensusParameters;
    }
}