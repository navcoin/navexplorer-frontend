<?php

namespace App\Navcoin\Common\Entity;

use JMS\Serializer\Annotation\Exclude;

abstract class IteratorEntity implements  \IteratorAggregate
{
    /**
     * @var string[]
     * @Exclude()
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

    /**
     * Add
     *
     * @param mixed $element
     *
     * @return self
     */
    public function add($element): self
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

    public function getElements(): array
    {
        return $this->elements;
    }

    public function setElements(array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }
}
