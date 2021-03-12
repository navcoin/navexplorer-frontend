<?php

namespace App\Navcoin\Common\Entity;

use Symfony\Component\Serializer\Annotation\Ignore;

abstract class IteratorEntity implements \IteratorAggregate, IteratorEntityInterface
{
    /**
     * @var string[]
     */
    protected $supportedTypes = [];

    /**
     * @var array
     */
    private $elements = [];

    public function __construct()
    {
        $this->setSupportedTypes();
    }

    abstract function setSupportedTypes();

    public function add($element): IteratorEntityInterface
    {
        foreach ($this->supportedTypes as $supportedType) {
            if ($element instanceof $supportedType) {
                array_push($this->elements, $element);
                return $this;
            }
        }

        throw new \InvalidArgumentException(
            sprintf('Cannot add a %s to %s', get_class($element), __CLASS__)
        );
    }

    public function getElement(int $index)
    {
        if (!array_key_exists($index, $this->getElements())) {
            throw new \RuntimeException(sprintf("Element %d does not exist", $index));
        }

        return $this->getElements()[0];
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function countElements(): int
    {
        return count($this->elements);
    }

    public function setElements(array $elements): IteratorEntityInterface
    {
        $this->elements = $elements;

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }
}
