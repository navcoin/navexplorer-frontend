<?php

namespace App\Navcoin\CommunityFund\Mapper;

use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\PaymentRequestVote;
use App\Navcoin\CommunityFund\Entity\PaymentRequestVotes;

class PaymentRequestMapper extends BaseMapper
{
    public function mapEntity(array $data): PaymentRequest
    {
        $paymentRequest = new PaymentRequest(
            $data['version'],
            $data['hash'],
            $data['blockHash'],
            $data['proposalHash'],
            $data['description'],
            $data['requestedAmount'],
            $this->mapPaymentRequestVotes($data['paymentRequestVotes']),
            $data['state'],
            $data['status']
        );

        if ($data['state'] == "ACCEPTED") {
            $paymentRequest->setApprovedOnBlock($data['approvedOnBlock']);
            $paymentRequest->setPaidOnBlock($data['paidOnBlock']);
        }

        return $paymentRequest;
    }

    public function mapPaymentRequestVotes(array $data): PaymentRequestVotes
    {
        $proposalVotes = new PaymentRequestVotes();

        foreach ($data as $voteData) {
            $proposalVotes->add(
                new PaymentRequestVote($voteData['votesYes'], $voteData['votesNo'], $voteData['votingCycle'])
            );
        }

        return $proposalVotes;
    }
}
