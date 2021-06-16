<?php

namespace App\Navcoin\Common\Entity;

trait Paginated
{
    private $paginator;

    public function setPaginator($paginator): void
    {
        $this->paginator = $paginator;
    }

    public function getPaginator(): ?Paginator
    {
        return $this->paginator;
    }

    public function isPaginated(): bool
    {
        return $this->paginator ? true : false;
    }
}