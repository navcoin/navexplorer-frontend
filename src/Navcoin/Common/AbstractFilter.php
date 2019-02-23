<?php

namespace App\Navcoin\Common;

abstract class AbstractFilter
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    private $filters;

    public function __construct()
    {
        $this->setClass();
        $this->getFilters();
    }

    public abstract function setClass();

    public function getFilters(): array
    {
        if (is_null($this->filters)) {
            $class = new \ReflectionClass($this->class);
            $this->filters = array_values($class->getConstants());
        }

        return $this->filters;
    }

    public function createFilterQuery(array $filters): string
    {
        if (empty($filters) || $filters === $this->getFilters()) {
            return '';
        }

        return 'filters=' . implode(',', array_intersect($filters, $this->getFilters()));
    }
}
