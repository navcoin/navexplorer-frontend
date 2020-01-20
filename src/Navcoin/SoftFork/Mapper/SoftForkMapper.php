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
        $sf = new SoftFork(
            $data['name'],
            $data['signalBit'],
            $data['state'],
            $this->getData('lockedinheight', $data),
            $this->getData('activationheight', $data),
            $this->getData('signalheight', $data)
        );

        if ($this->hasData('cycles', $data) && is_array($data['cycles'])) {
            foreach ($data['cycles'] as $cycle) {
                $sf->addCycle($cycle['cycle'], $cycle['blocks']);
            }
        }

        return $sf;
    }

    function sortBySignals(SoftFork $a, SoftFork $b)
    {
        return true;
//        return $a->getBlocksSignalling() < $b->getBlocksSignalling();
    }
}
