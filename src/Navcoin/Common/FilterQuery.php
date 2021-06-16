<?php

namespace App\Navcoin\Common;

class FilterQuery
{
    public static function generate(array $filters): string {
        $query = "";
        foreach($filters as $name => $value) {
            $query .= $name.':'.$value.',';
        }
        $query = rtrim($query, ',');

        return $query;
    }
}