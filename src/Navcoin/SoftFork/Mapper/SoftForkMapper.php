<?php

namespace App\Navcoin\SoftFork\Mapper;

use App\Navcoin\Common\Mapper\MapperInterface;
use App\Navcoin\SoftFork\Entity\SoftFork;
use App\Navcoin\SoftFork\Entity\SoftForks;

class SoftForkMapper implements MapperInterface
{
    public function mapIterator(array $data, String $class = null): SoftForks
    {
        $softForks = new SoftForks();

        foreach ($data as $softFork) {
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
            $data['blocksInCycle'],
            $data['blocksInCycle'] * 0.75,
            $data['blocksSignalling'],
            $data['blocksRemaining'],
            $data['lockedInHeight'],
            $data['activationHeight']
        );
    }

    function sortBySignals(SoftFork $a, SoftFork $b)
    {
        return $a->getBlocksSignalling() < $b->getBlocksSignalling();
    }
}
