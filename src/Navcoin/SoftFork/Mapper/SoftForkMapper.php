<?php

namespace App\Navcoin\SoftFork\Mapper;

use App\Navcoin\Common\Entity\Paginator;
use App\Navcoin\Common\Mapper\BaseMapper;
use App\Navcoin\Common\Mapper\MapperInterface;
use App\Navcoin\SoftFork\Entity\SoftFork;
use App\Navcoin\SoftFork\Entity\SoftForks;

class SoftForkMapper extends BaseMapper
{
    public function mapIterator(String $class, array $data, Paginator $paginator = null, array $options = [])
    {
        $softForks = new SoftForks(
            $data['blockCycle'],
            $data['blocksInCycle'],
            $data['firstBlock'],
            $data['currentBlock'],
            $data['blocksRemaining']
        );

        foreach ($data['softForks'] as $softFork) {
            $softForks->add($this->mapEntity($softFork));
        }
        $elements = $softForks->getElements();
        usort($elements, [$this, 'sortBySignals']);

        return $softForks->setElements($elements);
    }

    public function mapEntity(array $data): SoftFork
    {
        return new SoftFork(
            $data['name'],
            $data['state'],
            $data['blocksSignalling'],
            $this->getData('lockedInHeight', $data),
            $this->getData('activationHeight', $data)
        );
    }

    function sortBySignals(SoftFork $a, SoftFork $b)
    {
        return $a->getBlocksSignalling() < $b->getBlocksSignalling();
    }
}
