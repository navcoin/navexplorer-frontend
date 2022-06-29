<?php

namespace App\Navcoin\CommunityFund\Api;

use App\Exception\ServerRequestException;
use App\Navcoin\Client\NavcoinClientInterface;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\Mapper\MapperInterface;
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
    public function getStats(): Stats
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/stats');
            $data = $this->getClient()->getJsonBody($response);

            $stats = new Stats(0, $data['available'], $data['paid'], $data['locked']);
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

    public function getByStatus(string $status, $order = 'id'): Proposals
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/proposal?size=5000&status='.$status);
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

    public function getProposals(array $parameters, int $size = 10, int $page = 1, $paginate = false): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get('/dao/cfund/proposal?size='.$size.'&page='.$page.'&'.http_build_query($parameters));
            $data = $this->getClient()->getJsonBody($response);
        } catch (ServerRequestException $e) {
            return new Proposals();
        }

        $paginator = $paginate ? $this->getClient()->getPaginator($response) : null;
        return $this->getMapper()->mapIterator(Proposals::class, $data, $paginator);
    }
}
