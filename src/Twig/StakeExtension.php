<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StakeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('nav', [$this, 'formatNav'], ['is_safe' => ['html']]),
            new TwigFilter('xnav', [$this, 'formatXNav'], ['is_safe' => ['html']]),
            new TwigFilter('wnav', [$this, 'formatWNav'], ['is_safe' => ['html']]),
        ];
    }

    public function formatNav(float $number, bool $sign = false, int $decimalPlaces = 8): string {
        return $this->stakeFormat($number, $sign, $decimalPlaces).'&nbsp;Nav';
    }

    public function formatXNav(float $number, bool $sign = false, int $decimalPlaces = 8): string {
        return $this->stakeFormat($number, $sign, $decimalPlaces).'&nbsp;xNav';
    }

    public function formatWNav(float $number, bool $sign = false, int $decimalPlaces = 8): string {
        return $this->stakeFormat($number, $sign, $decimalPlaces).'&nbsp;wNav';
    }

    private function stakeFormat(float $number, bool $sign = false, int $decimalPlaces = 8): string
    {
        if ($number === 0.0) {
            return "0";
        }

        if ($number < 1) {
            $stake = sprintf('%.8f', $number);
        } else {
            $stake = rtrim(rtrim(number_format($number, $decimalPlaces,'.', ','), '0'), '.');
        }
        if ($number < 0) {
            $stake = preg_replace('/(\-)/', '-&nbsp;', $stake);
        } else if ($sign === true) {
            $stake = '+&nbsp;' . $stake;
        }

        return preg_replace('/\.([0-9]*)$/', '.<small>$1</small>', $stake);
    }
}
