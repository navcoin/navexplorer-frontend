<?php

namespace App\Navcoin\Common\Entity;

use JMS\Serializer\Annotation\Accessor;

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
    private $pageSize;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var array
     * @Accessor(getter="getElements",setter="setElements")
     */
    private $elements = [];

    public function add($element): IteratorEntityInterface
    {
        array_push($this->elements, $element);

        return $this;
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

    public function isLast(): bool
    {
        return $this->last;
    }

    public function setLast(bool $last): self
    {
        $this->last = $last;

        return $this;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): self
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    public function getTotalElements(): int
    {
        return $this->totalElements;
    }

    public function setTotalElements(int $totalElements): self
    {
        $this->totalElements = $totalElements;

        return $this;
    }

    public function isFirst(): bool
    {
        return $this->first;
    }

    public function setFirst(bool $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function getNumberOfElements(): int
    {
        return $this->numberOfElements;
    }

    public function setNumberOfElements(int $numberOfElements): self
    {
        $this->numberOfElements = $numberOfElements;

        return $this;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }
}
