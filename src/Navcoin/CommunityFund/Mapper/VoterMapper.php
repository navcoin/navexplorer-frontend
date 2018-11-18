<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Voter;

class VoterMapper extends BaseMapper
{
    public function mapEntity(array $data): Voter
    {
        return new Voter(
            $data['address'],
            $data['votes'],
            $this->options['vote']
        );
    }
}
