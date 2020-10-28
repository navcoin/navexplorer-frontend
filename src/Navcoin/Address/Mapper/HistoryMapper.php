<?php

namespace App\Navcoin\Address\Mapper;

use App\Navcoin\Address\Entity\AddressTransaction as Transaction;
use App\Navcoin\Address\Entity\Balance;
use App\Navcoin\Address\Entity\Changes;
use App\Navcoin\Address\Entity\History;
use App\Navcoin\Address\Entity\Result;
use App\Navcoin\Common\Mapper\BaseMapper;

class HistoryMapper extends BaseMapper
{
    public function mapEntity(array $data): History
    {
        return new History(
            $data['height'],
            $data['txindex'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['time']),
            $data['txid'],
            $data['hash'],
            $this->mapChanges($data['changes']),
            $this->mapBalance($data['balance']),
            $data['is_stake'],
            $data['is_cfund_payout'],
            $data['is_stake_payout']
        );
    }

    public function mapChanges(array $data): Changes
    {
        return new Changes(
            $data['spendable'] / 100000000,
            $data['stakable'] / 100000000,
            $data['voting_weight'] / 100000000
        );
    }

    public function mapBalance(array $data): Balance
    {
        return new Balance(
          $data['spendable'] / 100000000,
          $data['stakable'] / 100000000,
          $data['voting_weight'] / 100000000
        );
    }
}
