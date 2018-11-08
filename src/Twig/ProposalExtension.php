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

    public function getProposalVoteProgress(Proposal $proposal, BlockCycle $blockCycle): string
    {
        $minimumVotes = $blockCycle->getBlocksInCycle() * $blockCycle->getMinQuorum();
        $totalVotes =  $proposal->getVotesTotal() < $minimumVotes ? $minimumVotes : $proposal->getVotesTotal();
        $yesVotes = (int) round(($proposal->getVotesYes() / $totalVotes) * 100);
        $noVotes = (int) round(($proposal->getVotesNo() / $totalVotes) * 100);

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getState(), true), $yesVotes).'
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getState(), false), $noVotes).'
</div>';
    }

    public function getPaymentRequestVoteProgress(PaymentRequest $paymentRequest, BlockCycle $blockCycle): string
    {
        $minimumVotes = $blockCycle->getBlocksInCycle() * $blockCycle->getMinQuorum();
        $totalVotes =  $paymentRequest->getVotesTotal() < $minimumVotes ? $minimumVotes : $paymentRequest->getVotesTotal();
        $yesVotes = (int) round(($paymentRequest->getVotesYes() / $totalVotes) * 100);
        $noVotes = (int) round(($paymentRequest->getVotesNo() / $totalVotes) * 100);

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), true), $yesVotes).'
    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), false), $noVotes).'
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

    private function getProgressBarClass(String $state, bool $vote): string
    {
        $classes = [
            'progress-bar',
            $vote ? 'bg-success' : 'bg-danger',
        ];

        if ($state == 'PENDING') {
            $classes[] = 'progress-bar-striped';
            $classes[] = 'progress-bar-animated';
        }

        return implode(' ', $classes);
    }
}
