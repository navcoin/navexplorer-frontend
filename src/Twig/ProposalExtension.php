<?php

namespace App\Twig;

use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Entity\Voter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ProposalExtension extends AbstractExtension
{
    /**
     * @var BlockCycle
     */
    private $blockCycle;

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

    public function getProposalVoteProgress(Proposal $proposal, BlockCycle $blockCycle, Voter $voter): string
    {
        $this->blockCycle = $blockCycle;

        $abstentionBar = $this->getProgressBar($this->getProgressBarClass('abstention', null), $blockCycle->getCurrentBlock() - $voter->getTotal(), false);

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getStatus(), true), $voter->getYes()).'
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getStatus(), false), $voter->getNo()).'
    '.($proposal->getStatus() == 'pending' ? $abstentionBar : '').'
</div>';
    }

    public function getPaymentRequestVoteProgress(PaymentRequest $paymentRequest, BlockCycle $blockCycle): string
    {
        return '';
//        $this->blockCycle = $blockCycle;
//        $abstentionVotes = $blockCycle->getBlocksInCycle() - $blockCycle->getRemainingBlocks() - $paymentRequest->getVotesTotal();
//
//        $abstentionBar = $this->getProgressBar($this->getProgressBarClass('abstention', null), $abstentionVotes, false);
//        return '
//<div class="progress">
//    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), true), $paymentRequest->getVotesYes()).'
//    '.$this->getProgressBar($this->getProgressBarClass($paymentRequest->getState(), false), $paymentRequest->getVotesNo()).'
//    '.($paymentRequest->getState() == 'PENDING' ? $abstentionBar : '').'
//</div>';
    }

    public function getAnswerVotes(string $type, BlockCycle $blockCycle, int $count): string
    {
        $this->blockCycle = $blockCycle;

        $abstentionBar = $this->getProgressBar($this->getProgressBarClass('abstention', null), $blockCycle->getCurrentBlock() - $voter->getTotal(), false);

        return '
<div class="progress">
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getStatus(), true), $voter->getYes()).'
    '.$this->getProgressBar($this->getProgressBarClass($proposal->getStatus(), false), $voter->getNo()).'
    '.($proposal->getStatus() == 'pending' ? $abstentionBar : '').'
</div>';
    }

    public function getProposalStateTitle(String $state): string
    {
        return preg_replace('/(-|_)/', ' ', $state);
    }

    private function getProgressBar(string $classes, int $votes, bool $showPercent = true): string
    {
        $votesPercent = (int) round(($votes / $this->blockCycle->getBlocksInCycle()) * 100);
        return sprintf(
            '<div class="%s" role="progressbar" style="%s" aria-valuenow="%d" aria-valuemin="0" aria-valuemax="100">%s</div>',
            $classes,
            sprintf('width: %s&percnt;', $votesPercent),
            $votes,
            ($showPercent && $votesPercent > 10 ? sprintf('%s&percnt;', $votesPercent) : null)
        );
    }

    private function getProgressBarClass(String $state, $vote): string
    {
        $classes = ['progress-bar'];

        if ($vote === true) {
            array_push($classes, 'bg-success');
        } elseif ($vote === false) {
            array_push($classes, 'bg-danger');
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