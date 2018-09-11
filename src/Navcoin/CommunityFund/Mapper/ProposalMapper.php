<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Proposal;

class ProposalMapper extends BaseMapper
{
    public function mapEntity(array $data): Proposal
    {
        $proposal = new Proposal(
            $data['version'],
            $data['hash'],
            $data['blockHash'],
            $data['description'],
            $data['requestedAmount'],
            $data['notPaidYet'],
            $data['userPaidFee'],
            $data['paymentAddress'],
            $data['proposalDuration'],
            $data['votesYes'],
            $data['votesNo'],
            $data['votingCycle'],
            $data['state'],
            $data['status'],
            (new \DateTime())->setTimestamp($data['createdAt']/1000)
        );

        if ($data['state'] == "ACCEPTED") {
            $proposal->setApprovedOnBlock($data['approvedOnBlock']);
            $proposal->setExpiresOn((new \DateTime())->setTimestamp($data['expiresOn']));
        }

        return $proposal;
    }
}
