<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Balance;
use App\Navcoin\Address\Entity\Summary;
use App\Navcoin\Common\Mapper\BaseMapper;

class SummaryMapper extends BaseMapper
{
    public function mapEntity(array $data): Summary
    {
        return new Summary(
            $data['height'],
            $data['hash'],
            $this->mapResult($data['balance'])
        );
    }

    public function mapResult(array $data): Balance
    {
        return new Balance(
            $data['spending'] / 100000000,
            $data['staking'] / 100000000,
            $data['voting'] / 100000000
        );
    }
}
