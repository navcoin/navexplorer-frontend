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
        $response = $this->getClient()->get('/dao/cfund/block-cycle');
        $data = $this->getClient()->getJsonBody($response);

        return new BlockCycle(
            $data['blocksInCycle'],
            $data['minQuorum'],
            new BlockCycleVoting($data['proposalVoting']['cycles'], $data['proposalVoting']['accept'], $data['proposalVoting']['reject']),
            new BlockCycleVoting($data['paymentVoting']['cycles'], $data['paymentVoting']['accept'], $data['paymentVoting']['reject']),
            $data['currentBlock'],
            $data['cycle'],
            $data['firstBlock'],
            $data['currentBlock'] - $data['firstBlock']
        );
    }

    public function getStats(): Stats
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/stats');
            $data = $this->getClient()->getJsonBody($response);

            $stats = new Stats($data['contributed'], $data['available'], $data['paid'], $data['locked']);
        } catch (\Exception $e) {
            $stats = new Stats(0, 0, 0, 0);
        }

        return $stats;
    }

    public function getProposal(String $hash): Proposal
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/proposal/' . $hash);
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
            $response = $this->getClient()->get('/dao/cfund/proposal');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Proposals();
        }

        return $this->getMapper()->mapIterator(Proposals::class, $data);
    }

    public function getProposalsByState(string $state, string $order = 'id', ?int $page = 1): Proposals
    {
//        try {
            $response = $this->getClient()->get('/dao/cfund/proposal?size=15&page='.$page.'&status='.strtolower($state));
            $data = $this->getClient()->getJsonBody($response);
//        } catch (ServerRequestException $e) {
//            return new Proposals();
//        }

        $proposals = $this->getMapper()->mapIterator(Proposals::class, $data);

        if ($order == 'votes') {
            $proposals->sortByVotes();
        }

        return $proposals;
    }
}
