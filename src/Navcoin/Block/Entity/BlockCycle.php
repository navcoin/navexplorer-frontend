<?php


namespace App\Navcoin\Block\Entity;

class BlockCycle
{
    /** @var int */
    private $size;

    /** @var int */
    private $cycle;

    /** @var int */
    private $index;

    public function __construct(int $size, int $cycle, int $index)
    {
        $this->size = $size;
        $this->cycle = $cycle;
        $this->index = $index;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getCycle(): int
    {
        return $this->cycle;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getRemainingBlocks(): int
    {
        return $this->getSize() - $this->getIndex();
    }
}
