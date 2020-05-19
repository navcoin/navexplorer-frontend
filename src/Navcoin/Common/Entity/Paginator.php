<?php

namespace App\Navcoin\Common\Entity;

class Paginator
{
    /** @var int */
    private $pageSize;

    /**  @var int */
    private $totalPages;

    /**  @var int */
    private $totalElements;

    /**  @var int */
    private $currentPage;

    /**  @var bool */
    private $first;

    /** @var bool */
    private $last;

    public function __construct(int $pageSize, int $totalPages, int $totalElements, int $currentPage, bool $first, bool $last)
    {
        $this->pageSize = $pageSize;
        $this->totalPages = $totalPages;
        $this->totalElements = $totalElements;
        $this->currentPage = $currentPage;
        $this->first = $first;
        $this->last = $last;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getTotalElements(): int
    {
        return $this->totalElements;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function isFirst(): bool
    {
        return $this->first;
    }

    public function isLast(): bool
    {
        return $this->last;
    }

    public function getPreviousPage(): int
    {
        return $this->currentPage == 1 ? 1 : $this->currentPage - 1;
    }

    public function getNextPage(): int
    {
        return $this->currentPage == $this->totalPages ? $this->totalPages : $this->currentPage + 1;
    }
}
