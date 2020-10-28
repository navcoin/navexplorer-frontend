<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\Balance;
use App\Navcoin\Address\Entity\Summary;
use App\Navcoin\Address\Entity\SummaryAccount;
use App\Navcoin\Common\Mapper\BaseMapper;

class SummaryMapper extends BaseMapper
{
    public function mapEntity(array $data): Summary
    {
        return new Summary(
            $data['height'],
            $data['hash'],
            $data['txs'],
            $this->mapAccount($data['spendable']),
            $this->mapAccount($data['stakable']),
            $this->mapAccount($data['voting_weight'])
        );
    }

    public function mapAccount(array $data): SummaryAccount
    {
        return new SummaryAccount(
            $data['balance'] / 100000000,
            $data['staked'] / 100000000,
            $data['sent'] / 100000000,
            $data['received'] / 100000000
        );
    }
}
