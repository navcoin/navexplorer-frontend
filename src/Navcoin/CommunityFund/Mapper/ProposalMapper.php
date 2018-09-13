<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Entity\ProposalVote;
use App\Navcoin\CommunityFund\Entity\ProposalVotes;

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
            $this->mapProposalVotes($data['proposalVotes']),
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

    public function mapProposalVotes(array $data): ProposalVotes
    {
        $proposalVotes = new ProposalVotes();

        foreach ($data as $voteData) {
            $proposalVotes->add(
                new ProposalVote($voteData['votesYes'], $voteData['votesNo'], $voteData['votingCycle'])
            );
        }

        return $proposalVotes;
    }
}
