<?php

namespace App\Navcoin\Common\Entity;

use JMS\Serializer\Annotation\Accessor;

/**
 * Class Paginator
 *
 * @package App\Navcoin\Common\Entity
 */
class Paginator implements IteratorEntityInterface
{
    /**
     * @var bool
     */
    private $last;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var int
     */
    private $totalElements;

    /**
     * @var bool
     */
    private $first;

    /**
     * @var int
     */
    private $numberOfElements;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $number;

    /**
     * @var IteratorEntity
     * @Accessor(getter="getElements",setter="setElements")
     */
    private $elements;

    /**
     * Add
     *
     * @param mixed $element
     *
     * @return self
     */
    public function add($element): self
    {
        $this->elements->add($element);

        return $this;
    }

    /**
     * Get Iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return $this->elements->getIterator();
    }

    /**
     * Get Last
     *
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->last;
    }

    /**
     * Set Last
     *
     * @param bool $last
     *
     * @return $this
     */
    public function setLast(bool $last): self
    {
        $this->last = $last;

        return $this;
    }

    /**
     * Get TotalPages
     *
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * Set TotalPages
     *
     * @param int $totalPages
     *
     * @return $this
     */
    public function setTotalPages(int $totalPages): self
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * Get TotalElements
     *
     * @return int
     */
    public function getTotalElements(): int
    {
        return $this->totalElements;
    }

    /**
     * Set TotalElements
     *
     * @param int $totalElements
     *
     * @return $this
     */
    public function setTotalElements(int $totalElements): self
    {
        $this->totalElements = $totalElements;

        return $this;
    }

    /**
     * Get First
     *
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->first;
    }

    /**
     * Set First
     *
     * @param bool $first
     *
     * @return $this
     */
    public function setFirst(bool $first): self
    {
        $this->first = $first;

        return $this;
    }

    /**
     * Get NumberOfElements
     *
     * @return int
     */
    public function getNumberOfElements(): int
    {
        return $this->numberOfElements;
    }

    /**
     * Set NumberOfElements
     *
     * @param int $numberOfElements
     *
     * @return $this
     */
    public function setNumberOfElements(int $numberOfElements): self
    {
        $this->numberOfElements = $numberOfElements;

        return $this;
    }

    /**
     * Get Size
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set Size
     *
     * @param int $size
     *
     * @return $this
     */
    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get Number
     *
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * Set Number
     *
     * @param int $number
     *
     * @return $this
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get Elements
     *
     * @return IteratorEntity
     */
    public function getElements()
    {
        return $this->elements->getElements();
    }

    /**
     * Set Elements
     *
     * @param IteratorEntity $elements
     *
     * @return $this
     */
    public function setElements(IteratorEntity $elements): self
    {
        $this->elements = $elements;

        return $this;
    }
}
