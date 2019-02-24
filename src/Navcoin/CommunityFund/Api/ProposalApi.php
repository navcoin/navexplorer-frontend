<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Common\NavcoinApi;
use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\BlockCycleVoting;
use App\Navcoin\CommunityFund\Entity\Proposals;
use App\Navcoin\CommunityFund\Entity\Stats;
use App\Navcoin\CommunityFund\Exception\CommunityFundProposalNotFound;
use App\Navcoin\CommunityFund\Entity\Proposal;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class ProposalApi extends NavcoinApi
{
    public function getBlockCycle(): BlockCycle
    {
        $response = $this->getClient()->get('/api/community-fund/block-cycle');
        $data = $this->getClient()->getJsonBody($response);

        return new BlockCycle(
            $data['blocksInCycle'],
            $data['minQuorum'],
            new BlockCycleVoting($data['proposalVoting']['cycles'], $data['proposalVoting']['accept'], $data['proposalVoting']['reject']),
            new BlockCycleVoting($data['paymentVoting']['cycles'], $data['paymentVoting']['accept'], $data['paymentVoting']['reject']),
            $data['height'],
            $data['cycle'],
            $data['firstBlock'],
            $data['currentBlock']
        );
    }

    public function getStats(): Stats
    {
        try {
            $response = $this->getClient()->get('/api/community-fund/stats');
            $data = $this->getClient()->getJsonBody($response);

            $stats = new Stats($data['contributed'], $data['requested'], $data['paid'], $data['locked']);
        } catch (\Exception $e) {
            $stats = new Stats(0, 0, 0, 0);
        }

        return $stats;
    }

    public function getProposal(String $hash): Proposal
    {
        try {
            $response = $this->getClient()->get('/api/community-fund/proposal/' . $hash);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new CommunityFundProposalNotFound(sprintf("The `%s` proposal does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getAll(): Proposals
    {
        try {
            $response = $this->getClient()->get('/api/community-fund/proposal');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Proposals();
        }

        return $this->getMapper()->mapIterator(Proposals::class, $data);
    }

    public function getProposalsByState(string $state, $order = 'id'): Proposals
    {
        try {
            $response = $this->getClient()->get('/api/community-fund/proposal?state='.$state);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Proposals();
        }

        $proposals = $this->getMapper()->mapIterator(Proposals::class, $data);

        if ($order == 'votes') {
            $proposals->sortByVotes();
        }

        return $proposals;
    }
}
