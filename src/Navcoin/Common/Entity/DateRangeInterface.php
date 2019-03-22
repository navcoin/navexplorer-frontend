<?php

namespace App\Navcoin\Common\Entity;

interface DateRangeInterface
{
    public function getStart(): \DateTime;
    public function getEnd();
}