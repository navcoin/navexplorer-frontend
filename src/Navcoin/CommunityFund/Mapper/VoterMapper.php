<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Voter;
use App\Navcoin\CommunityFund\Entity\VoterAddress;

class VoterMapper extends BaseMapper
{
    public function mapEntity(array $data): Voter
    {
        $voter = new Voter(
            $data['cycle'],
            $data['yes'],
            $data['no'],
            $data['abstain'],
            $data['exclude']
        );

        $addresses = [];
        foreach($data['addresses'] as $address) {
            $addresses[] = new VoterAddress($address['address'], $address['yes'], $address['no'], $address['abstain'], $address['exclude']);
        }
        $voter->setAddresses($addresses);

        return $voter;
    }
}
