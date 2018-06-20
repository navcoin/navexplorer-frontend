<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class OrdinalExtension
 *
 * @package App\Twig
 */
class OrdinalExtension extends AbstractExtension
{
    /**
     * Get filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return array(
            new TwigFilter('ordinal', [$this, 'ordinal'], ['is_safe' => ['html']]),
        );
    }

    /**
     * Stake filter
     *
     * @param float $number
     *
     * @return string
     */
    public function ordinal(float $number): string
    {
        $ends = ['th','st','nd','rd','th','th','th','th','th','th'];

        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return number_format($number, 0).'th';
        }

        return number_format($number, 0).$ends[$number % 10];
    }
}
