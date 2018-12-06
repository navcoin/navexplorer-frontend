<?php

namespace App\Twig;

use App\Navcoin\Block\Entity\Block;
use App\Navcoin\Block\Entity\BlockGroup;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return array(
            new TwigFilter('date_localised', [$this, 'dateLocalised'], ['is_safe' => ['html']]),
        );
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('period', [$this, 'period'], ['is_safe' => ['html']]),
        ];
    }

    public function dateLocalised(\DateTime $date, string $format): string
    {
        return sprintf(
            '<span class="date-localised" data-timestamp="%s">%s</span>',
            $date->getTimestamp() * 1000,
            $date->format($format)
        );
    }

    public function period(String $period, int $index, BlockGroup $block) {
        switch ($period) {
            case 'hourly':
                return $this->hourly($index, $block);
            case 'daily':
                return $this->daily($index, $block);
            case 'monthly':
                return $this->monthly($index, $block);
        }
    }

    public function hourly(int $index, BlockGroup $block)
    {
        switch ($index) {
            case 0:
                return sprintf("%s - %s", $block->getEnd()->format('H:i'), $block->getStart()->format('H:i'));
            default:
                $start = clone $block->getEnd();
                $start->add(new \DateInterval('PT1H'));

                return sprintf("%s - %s", $block->getEnd()->format('H:i'), $start->format('H:i'));
        }
    }

    public function daily(int $index, BlockGroup $block)
    {
        switch ($index) {
            case 0:
                return 'Today';
            case 1:
                return 'Yesterday';
            default:
                return $block->getEnd()->format('D jS M');
        }
    }

    public function monthly(int $index, BlockGroup $block)
    {
        switch ($index) {
            case 0:
                return 'This month';
            default:
                return $block->getEnd()->format('F');
        }
    }
}
