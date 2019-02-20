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
                return $this->hourly($block);
            case 'daily':
                return $this->daily($block);
            case 'monthly':
                return $this->monthly($block);
        }
    }

    public function hourly(BlockGroup $block)
    {
        return sprintf("%s - %s", $block->getStart()->format('H:i'), $block->getEnd()->format('H:i'));
    }

    public function daily(BlockGroup $block)
    {
        return $block->getStart()->format('D jS M');
    }

    public function monthly(BlockGroup $block)
    {
        return $block->getStart()->format('F Y');
    }
}
