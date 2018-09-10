<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\BlockCycleVoting;
use App\Navcoin\CommunityFund\Entity\Proposals;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use App\Navcoin\CommunityFund\Entity\Proposal;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class CommunityFundApi extends NavcoinApi
{
    public function getBlockCycle(): BlockCycle
    {
        $data = $this->getClient()->get('/api/community-fund/block-cycle');

        return new BlockCycle(
            $data['blocksInCycle'],
            $data['minQuorum'],
            new BlockCycleVoting($data['proposalVoting']['cycles'], $data['proposalVoting']['accept'], $data['proposalVoting']['reject']),
            new BlockCycleVoting($data['paymentVoting']['cycles'], $data['paymentVoting']['accept'], $data['paymentVoting']['reject']),
            $data['height'],
            $data['cycle'],
            $data['firstBlock'],
            $data['currentBlock'],
            $data['remainingBlocks']
        );
    }

    public function getProposal(String $id): Proposal
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/proposal/'.$id);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $id), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getProposalsByStatus($status): Proposals
    {
        try {
            $data = $this->getClient()->get('/api/community-fund/proposal?status='.$status);
        } catch (ServerRequestException $e) {
            return new Proposals();
        }

        return $this->getMapper()->mapIterator($data, Proposals::class);
    }
}
