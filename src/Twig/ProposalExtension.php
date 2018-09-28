<?php

namespace App\Twig;

use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\Proposal;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ProposalExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('proposalVoteProgress', [$this, 'getProposalVoteProgress'], ['is_safe' => ['html']]),
            new TwigFunction('paymentRequestVoteProgress', [$this, 'getPaymentRequestVoteProgress'], ['is_safe' => ['html']]),
        ];
    }

    public function getFilters(): array
    {
        return array(
            new TwigFilter('proposalState', [$this, 'getProposalStateTitle'], ['is_safe' => ['html']]),
        );
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

        $votingCycle = $proposal->getProposalVotes()->getLatestVotes()->getVotingCycle();
        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getState(), $votingCycle, true, $cycle), $yesVotes).'
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getState(), $votingCycle, false, $cycle), $noVotes).'
</div>';
    }

    public function getPaymentRequestVoteProgress(PaymentRequest $paymentRequest, BlockCycle $blockCycle, int $cycle = null): string
    {
        if ($cycle === null) {
            $paymentVote = $paymentRequest->getPaymentRequestVotes()->getLatestVotes();
        } else {
            $paymentVote = $paymentRequest->getPaymentRequestVotes()->getVotingCycle($cycle);
        }

        $minimumVotes = $blockCycle->getBlocksInCycle() * $blockCycle->getMinQuorum();
        $totalVotes =  $paymentVote->getVotesTotal() < $minimumVotes ? $minimumVotes : $paymentVote->getVotesTotal();
        $yesVotes = (int) round(($paymentVote->getVotesYes() / $totalVotes) * 100);
        $noVotes = (int) round(($paymentVote->getVotesNo() / $totalVotes) * 100);

        $votingCycle = $paymentRequest->getPaymentRequestVotes()->getLatestVotes()->getVotingCycle();

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), $votingCycle, true, $cycle), $yesVotes).'
    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), $votingCycle, false, $cycle), $noVotes).'
</div>';
    }

    public function getProposalStateTitle(String $state): string
    {
        return preg_replace('/(-|_)/', ' ', $state);
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

    private function getProgressBarClass(String $state, int $votingCycle, bool $vote, int $cycle = null): string
    {
        $classes = [
            'progress-bar',
            $vote ? 'bg-success' : 'bg-danger',
        ];

        if ($state == 'PENDING' && $cycle == $votingCycle) {
            $classes[] = 'progress-bar-striped';
            $classes[] = 'progress-bar-animated';
        }

        return implode(' ', $classes);
    }
}
