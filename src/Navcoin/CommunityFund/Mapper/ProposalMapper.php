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
            $data['state'],
            $this->getData('stateChangedOnBlock', $data, ''),
            $this->getData('updatedOnBlock', $data, ''),
            $data['status']
        );

        if ($this->getData('expiresOn', $data)) {
            $proposal->setExpiresOn(\DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['expiresOn']));
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
