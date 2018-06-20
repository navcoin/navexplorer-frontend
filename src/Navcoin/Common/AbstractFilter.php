<?php

namespace App\Navcoin\Common;

/**
 * Class AbstractFilter
 *
 * @package App\Navcoin\Common
 */
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setClass();
        $this->getFilters();
    }

    /**
     * Sets the class used for filtering
     */
    public abstract function setClass();

    /**
     * Get Filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        if (is_null($this->filters)) {
            $class = new \ReflectionClass($this->class);
            $this->filters = array_values($class->getConstants());
        }

        return $this->filters;
    }

    /**
     * Create filter query
     *
     * @param array $filters
     *
     * @return string
     */
    public function createFilterQuery(array $filters): string
    {
        if (empty($filters) || $filters === $this->getFilters()) {
            return '';
        }

        return 'filters=' . implode(',', array_intersect($filters, $this->getFilters()));
    }
}
