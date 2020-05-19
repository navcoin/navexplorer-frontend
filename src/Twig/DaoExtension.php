<?php

namespace App\Twig;

use App\Navcoin\CommunityFund\Entity\BlockCycle;
use App\Navcoin\CommunityFund\Entity\PaymentRequest;
use App\Navcoin\CommunityFund\Entity\Proposal;
use App\Navcoin\CommunityFund\Entity\Voter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DaoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('answerType', [$this, 'getAnswerType'], ['is_safe' => ['html']]),
        ];
    }

    public function getAnswerType(string $value, int $type): string
    {
        switch ($type) {
            case 0:
                return $value;
            case 1:
                return $value / 100 . '%';
            case 2:
                return $value/10000000 . '&nbsp;Nav';
            case 3:
                return $value == 0 ? 'false' : 'true';
        }
    }
}