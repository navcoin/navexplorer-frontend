<?php

namespace App\Navcoin\Common\Entity;

interface IteratorEntityInterface
{
    public function add($element): self;
    public function getElement(int $index);
    public function getElements(): array;
    public function countElements(): int;
    public function setElements(array $elements): self;
    public function getIterator(): \ArrayIterator;
}
