<?php

namespace App\Twig;

use App\Navcoin\Common\Entity\DateRangeInterface;
use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return array(
            new TwigFilter('date_localised', [$this, 'dateLocalised'], ['is_safe' => ['html']]),
            new TwigFilter('age', [$this, 'age'], ['is_safe' => ['html']]),
        );
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('period', [$this, 'period'], ['is_safe' => ['html']]),
        ];
    }

    public function dateLocalised(DateTime $date, string $format): string
    {
        return sprintf(
            '<span class="date-localised" data-timestamp="%s">%s</span>',
            $date->getTimestamp() * 1000,
            $date->format($format)
        );
    }

    public function age(DateTime $date): string
    {
        $diff = abs((new DateTime())->getTimestamp() - $date->getTimestamp());

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));

        $age = "";
        if ($years > 0) {
            $age .= sprintf("%d year%s", $years, $years==1?'':'s');
        }
        if ($months > 0) {
            if ($years) {
                $age .= ",";
            }
            $age .= sprintf(" %d month%s", $months, $months==1?'':'s');
        }
        if ($days > 0) {
            if ($months) {
                $age .= ",";
            }
            $age .= sprintf(" %d day%s", $days, $days==1?'':'s');
        }

        if ($age == "") {
            $age .= sprintf("%d hour%s", $hours, $hours==1?'':'s');
            if ($minutes) {
                $age .= sprintf(", %d minute%s", $minutes, $minutes==1?'':'s');
            }
        }

        return $age;
    }

    public function period(String $period, int $index, DateRangeInterface $block) {
        switch ($period) {
            case 'hourly':
                return $this->hourly($block);
            case 'daily':
                return $this->daily($block);
            case 'monthly':
                return $this->monthly($block);
        }
    }

    public function hourly(DateRangeInterface $block)
    {
        return sprintf("%s - %s", $block->getStart()->format('H:i'), $block->getEnd()->format('H:i'));
    }

    public function daily(DateRangeInterface $block)
    {
        return $block->getStart()->format('j F Y');
    }

    public function monthly(DateRangeInterface $block)
    {
        return $block->getStart()->format('F Y');
    }
}
