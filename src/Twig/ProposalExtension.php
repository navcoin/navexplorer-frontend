<?php

namespace App\Twig;

use App\Navcoin\Block\Entity\BlockCycle;
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
        return '
<div class="progress">
    '.$this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($proposal->getStatus(), "yes"), $proposal->getVotesYes()).'
    '.$this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($proposal->getStatus(), "no"), $proposal->getVotesNo()).'
    '.$this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($proposal->getStatus(), "abs"), $proposal->getVotesAbs()).'
</div>';
    }

    public function getPaymentRequestVoteProgress(PaymentRequest $paymentRequest, BlockCycle $blockCycle): string
    {
        return "
<div class=\"progress\">
    " . $this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($paymentRequest->getStatus(), "yes"), $paymentRequest->getVotesYes()) . "
    " . $this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($paymentRequest->getStatus(), "no"), $paymentRequest->getVotesNo()) . "
    " . $this->getProgressBar($blockCycle->getSize(), $this->getProgressBarClass($paymentRequest->getStatus(), "abs"), $paymentRequest->getVotesAbs(), false) . "
</div>";
    }

    public function getProposalStateTitle(String $state): string
    {
        return preg_replace('/(-|_)/', ' ', $state);
    }

    private function getProgressBar(int $size, string $classes, int $votes, bool $showPercent = true): string
    {
        $votesPercent = (int) round(($votes / $size) * 100);
        return sprintf(
            '<div class="%s" role="progressbar" style="%s" aria-valuenow="%d" aria-valuemin="0" aria-valuemax="100">%s</div>',
            $classes,
            sprintf('width: %s&percnt;', $votesPercent),
            $votes,
            ($showPercent && $votesPercent > 10 ? sprintf('%s&percnt;', $votesPercent) : null)
        );
    }

    private function getProgressBarClass(String $state, ?string $vote): string
    {
        $classes = ['progress-bar'];

        if ($vote === "yes") {
            array_push($classes, 'bg-success');
        } elseif ($vote === "no") {
            array_push($classes, 'bg-danger');
        } elseif ($vote === "abs") {
            array_push($classes, 'bg-abstain');
        } else {
            array_push($classes, 'bg-grey');
        }

        if ($state == 'pending') {
            $classes[] = 'progress-bar-striped';
            $classes[] = 'progress-bar-animated';
        }

        return implode(' ', $classes);
    }
}