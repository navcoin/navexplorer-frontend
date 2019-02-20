<?php

namespace App\Navcoin\Block\Mapper;

use App\Navcoin\Block\Entity\Block;
use App\Navcoin\Block\Entity\BlockSignal;
use App\Navcoin\Block\Entity\BlockSignals;
use App\Navcoin\Common\Mapper\BaseMapper;

class BlockMapper extends BaseMapper
{
    public function mapEntity(array $data): Block
    {
        return new Block(
            $data['hash'],
            $data['merkleRoot'],
            $data['bits'],
            $data['size'],
            $data['version'],
            $data['nonce'],
            $data['height'],
            $data['difficulty'],
            $data['confirmations'],
            \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $data['created']),
            $data['stake'],
            $data['fees'],
            $data['spend'],
            $this->getData('cfundPayout', $data, 0),
            $data['stakedBy'] ?: '',
            $data['transactions'],
            $this->getData('best', $data),
            array_key_exists('raw', $data)  && $data['raw'] ? $data['raw'] : '',
            $data['balance']
        );
    }
}
