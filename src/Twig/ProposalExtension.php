<?php

namespace App\Twig;

use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\Proposal;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProposalExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('proposalVotesTotal', [$this, 'getProposalVotesTotal'], ['is_safe' => ['html']]),
            new TwigFunction('proposalVotesYes', [$this, 'getProposalVotesYes'], ['is_safe' => ['html']]),
            new TwigFunction('proposalVotesNo', [$this, 'getProposalVotesNo'], ['is_safe' => ['html']]),
        ];
    }

    public function getProposalVotesTotal(Proposal $proposal, BlockCycle $blockCycle): int
    {
        return ($proposal->getVotesTotal() / ($blockCycle->getBlocksInCycle() * $blockCycle->getMinQuorum())) * 100;
    }

    public function getProposalVotesYes(Proposal $proposal, BlockCycle $blockCycle): int
    {
        return ($proposal->getVotesYes() / ($blockCycle->getBlocksInCycle() * $blockCycle->getProposalVoting()->getAccept())) * 100;
    }

    public function getProposalVotesNo(Proposal $proposal, BlockCycle $blockCycle): int
    {
        return ($proposal->getVotesNo() / ($blockCycle->getBlocksInCycle() * $blockCycle->getProposalVoting()->getReject())) * 100;
    }
}
