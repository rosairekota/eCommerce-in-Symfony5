<?php

namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [new TwigFilter('dateFR', [$this, 'myDate'])];
    }
    public function getFunctions()
    {
        return
            [
                new TwigFunction('dateFR', [$this, 'myDate']),
                new TwigFunction('substring', [$this, 'substring'])
            ];
    }
    public function myDate($dates)
    {
        $months = [
            'january'   => 'Janvier',
            'febrary'   => 'Fevrier',
            'march'   => 'Mars',
            'april'   => 'Avril',
            'may'   => 'Mai',
        ];



        foreach ($months as $key => $month_fr) {
            if (\strtolower($dates) === $key) {
                return $month_fr;
            }
        }
    }

    public function substring($datas, $options = [])
    {
        $defaltOptions = [
            'start'     => 0,
            'end'       => 10,
        ];
        $options = array_merge($defaltOptions, $options);
        $start = $options['start'];
        $end = $options['end'];

        return substr($datas, $start, $end);
    }
}
