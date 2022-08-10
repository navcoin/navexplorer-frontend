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
            isset($data['cycle']) ? $data['cycle'] : 0,
            isset($data['yes']) ? $data['yes'] : 0,
            isset($data['no']) ? $data['no'] : 0,
            isset($data['abstain']) ? $data['abstain'] : 0,
            isset($data['exclude']) ? $data['exclude'] : 0
        );

        $addresses = [];
        foreach($data['addresses'] as $address) {
            $address['address'] = isset($address['address']) ? $address['address'] : 0;
            $address['yes'] = isset($address['yes']) ? $address['yes'] : 0;
            $address['no'] = isset($address['no']) ? $address['no'] : 0;
            $address['abstain'] = isset($address['abstain']) ? $address['abstain'] : 0;
            $address['exclude'] = isset($address['exclude']) ? $address['exclude'] : 0;
            $addresses[] = new VoterAddress($address['address'], $address['yes'], $address['no'], $address['abstain'], $address['exclude']);
        }
        $voter->setAddresses($addresses);

        return $voter;
    }
}
