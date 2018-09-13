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
            new TwigFunction('proposalVoteProgress', [$this, 'getProposalVoteProgress'], ['is_safe' => ['html']]),
        ];
    }

    public function getProposalVoteProgress(Proposal $proposal, BlockCycle $blockCycle, int $cycle = null): string
    {
        if ($cycle === null) {
            $proposalVote = $proposal->getProposalVotes()->getLatestVotes();
        } else {
            $proposalVote = $proposal->getProposalVotes()->getVotingCycle($cycle);
        }

        $minimumVotes = $blockCycle->getBlocksInCycle() * $blockCycle->getMinQuorum();
        $totalVotes =  $proposalVote->getVotesTotal() < $minimumVotes ? $minimumVotes : $proposalVote->getVotesTotal();
        $yesVotes = (int) round(($proposalVote->getVotesYes() / $totalVotes) * 100);
        $noVotes = (int) round(($proposalVote->getVotesNo() / $totalVotes) * 100);

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($proposal, true), $yesVotes).'
    '.$this->getProgressBar($this->getProgressBarClass($proposal, false), $noVotes).'
</div>';
    }

    private function getProgressBar(string $classes, int $votes): string
    {
        return sprintf(
            '<div class="%s" role="progressbar" style="%s" aria-valuenow="%d" aria-valuemin="0" aria-valuemax="100">%s</div>',
            $classes,
            sprintf('width: %s&percnt;', $votes),
            $votes,
            ($votes > 10 ? sprintf('%s&percnt;', $votes) : null)
        );
    }

    private function getProgressBarClass(Proposal $proposal, bool $vote): string
    {
        $classes = [
            'progress-bar',
            $vote ? 'bg-success' : 'bg-danger',
        ];

        if ($proposal->getState() == 'PENDING') {
            $classes[] = 'progress-bar-striped';
            $classes[] = 'progress-bar-animated';
        }

        return implode(' ', $classes);
    }
}
