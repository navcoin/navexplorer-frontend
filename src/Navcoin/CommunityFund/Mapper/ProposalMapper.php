<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Proposal;

class ProposalMapper extends BaseMapper
{
    public function mapEntity(array $data): Proposal
    {
        return new Proposal(
            $data['version'],
            $data['hash'],
            $data['description'],
            $data['requestedAmount'],
            $data['notPaidYet'],
            $data['userPaidFee'],
            $data['paymentAddress'],
            $data['proposalDuration'],
            $data['votesYes'],
            $data['votesNo'],
            $data['status']
        );
    }
}
