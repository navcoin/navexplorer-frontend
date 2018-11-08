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
            $data['height'],
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
            $data['stateChangedOnBlock'],
            $data['status'],
            (new \DateTime())->setTimestamp($data['createdAt']/1000)
        );

        if (array_key_exists('expiresOn', $data) && $data['expiresOn'] != null) {
            $proposal->setExpiresOn((new \DateTime())->setTimestamp($data['expiresOn']/1000));
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
