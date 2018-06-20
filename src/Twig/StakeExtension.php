<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class StakeExtension
 *
 * @package App\Twig
 */
class StakeExtension extends AbstractExtension
{
    /**
     * Get filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('stake_format', [$this, 'stakeFormat'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Stake filter
     *
     * @param float $number
     * @param bool  $sign
     * @param int   $decimalPlaces
     *
     * @return string
     */
    public function stakeFormat(float $number, bool $sign = false, int $decimalPlaces = 8): string
    {
        $stake = rtrim(rtrim(number_format($number, $decimalPlaces,'.', ','), '0'), '.');

        if ($number < 0) {
            $stake = preg_replace('/(\-)/', '-&nbsp;', $stake);
        } else if ($sign === true) {
            $stake = '+&nbsp;'.$stake;
        }

        return preg_replace('/\.([0-9]*)$/', '.<small>$1</small>', $stake) . '&nbsp;NAV';
    }

}
