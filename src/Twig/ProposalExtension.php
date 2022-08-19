<?php

namespace App\Twig;

use App\Navcoin\Block\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Entity\Voter;
use App\Navcoin\CommunityFund\Constants\ProposalState;
use App\Navcoin\CommunityFund\Constants\PaymentRequestState;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ProposalExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('proposalVoteProgress', [$this, 'getProposalVoteProgress'], ['is_safe' => ['html']]),
            new TwigFunction('proposalVoteProgressParticipation', [$this, 'getProposalVoteProgressParticipation'], ['is_safe' => ['html']]),
            new TwigFunction('paymentRequestVoteProgress', [$this, 'getPaymentRequestVoteProgress'], ['is_safe' => ['html']]),
            new TwigFunction('paymentRequestVoteProgressParticipation', [$this, 'getPaymentRequestVoteProgressParticipation'], ['is_safe' => ['html']]),
            new TwigFunction('loaderDots', [$this, 'getLoaderDots'], ['is_safe' => ['html']]),
        ];
    }

    public function getLoaderDots() : string
    {
        return '<div>
            <div class="spinner-grow text-nav1" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-nav2" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-nav3" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-nav4" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-nav5" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>';
    }

    public function getFilters(): array
    {
        return array(
            new TwigFilter('proposalState', [$this, 'getProposalStateTitle'], ['is_safe' => ['html']]),
        );
    }

    public function getProposalVoteProgress(Proposal $proposal, BlockCycle $blockCycle): string
    {
        $size = $proposal->getVotesYes() + $proposal->getVotesNo() + $proposal->getVotesAbs();
        return '
<div class="progress">
    '.$this->getProgressBar($size, $this->getProgressBarClass($proposal->getStatus(), "yes"), $proposal->getVotesYes()).'
    '.$this->getProgressBar($size, $this->getProgressBarClass($proposal->getStatus(), "no"), $proposal->getVotesNo()).'
    '.$this->getProgressBar($size, $this->getProgressBarClass($proposal->getStatus(), "abs"), $proposal->getVotesAbs()).'
</div>';
    }

    public function getProposalVoteProgressParticipation(Proposal $p, BlockCycle $blockCycle): string
    {
        $blocks = ($p->getState() == ProposalState::PENDING ? $blockCycle->getIndex() : $blockCycle->getSize());
        $votes = $p->getVotesYes() + $p->getVotesNo() + $p->getVotesAbs();
        $excluded = $p->getVotesExcluded();
        $size = $blocks - $excluded;
        $uncommited = $size - $votes;
        $customContents =
            $this->getProgressBar($size, $this->getProgressBarClass($p->getStatus(), "yes"), $votes).' '.
            $this->getProgressBar($size, $this->getProgressBarClass($p->getStatus(), ""), $uncommited);

        return '
<div class="progress">
    '.$this->getProgressBar($blockCycle->getSize(), "progress", $votes + $uncommited + $excluded, true, $customContents).'
</div>';
    }

    public function getPaymentRequestVoteProgress(PaymentRequest $paymentRequest, BlockCycle $blockCycle): string
    {
        $size = $paymentRequest->getVotesYes() + $paymentRequest->getVotesNo() + $paymentRequest->getVotesAbs();
        return "
<div class=\"progress\">
    " . $this->getProgressBar($size, $this->getProgressBarClass($paymentRequest->getStatus(), "yes"), $paymentRequest->getVotesYes()) . "
    " . $this->getProgressBar($size, $this->getProgressBarClass($paymentRequest->getStatus(), "no"), $paymentRequest->getVotesNo()) . "
    " . $this->getProgressBar($size, $this->getProgressBarClass($paymentRequest->getStatus(), "abs"), $paymentRequest->getVotesAbs(), false) . "
</div>";
    }

    public function getPaymentRequestVoteProgressParticipation(PaymentRequest $p, BlockCycle $blockCycle): string
    {
        $blocks = ($p->getState() == PaymentRequestState::PENDING ? $blockCycle->getIndex() : $blockCycle->getSize());
        $votes = $p->getVotesYes() + $p->getVotesNo() + $p->getVotesAbs();
        $excluded = $p->getVotesExcluded();
        $size = $blocks - $excluded;
        $uncommited = $size - $votes;
        $customContents =
            $this->getProgressBar($size, $this->getProgressBarClass($p->getStatus(), "yes"), $votes).' '.
            $this->getProgressBar($size, $this->getProgressBarClass($p->getStatus(), ""), $uncommited);

        return '
<div class="progress">
    '.$this->getProgressBar($blockCycle->getSize(), "progress", $votes + $uncommited + $excluded, true, $customContents).'
</div>';
    }

    public function getProposalStateTitle(String $state): string
    {
        return preg_replace('/(-|_)/', ' ', $state);
    }

    private function getProgressBar(int $size, string $classes, int $votes, bool $showPercent = true, string $customContents = ''): string
    {
        $votesPercent = 0;
        $votesPercentRounded = 0;
        if ($size > 0) {
            $votesPercent = ($votes / $size) * 100;
            $votesPercentRounded = round($votesPercent);
        }
        return sprintf(
            '<div class="%s" role="progressbar" style="%s" aria-valuenow="%d" aria-valuemin="0" aria-valuemax="100">%s</div>',
            $classes,
            sprintf('width: %s&percnt;', $votesPercent),
            $votes,
            ($customContents != '' ? $customContents : ($showPercent && $votesPercent > 9 ? sprintf('%s&percnt;', $votesPercentRounded) : null))
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
