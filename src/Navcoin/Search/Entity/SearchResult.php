<?php

namespace App\Navcoin\Search\Entity;

/**
 * Class SearchResult
 *
 * @package App\Navcoin\Search\Entity
 */
class SearchResult
{
    /**
     * @var String
     */
    private $type;

    /**
     * @var String
     */
    private $value;

    /**
     * Constructor
     *
     * @param String $type
     * @param String $value
     */
    public function __construct(String $type, String $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get Type
     *
     * @return String
     */
    public function getType(): String
    {
        return $this->type;
    }

    /**
     * Get Value
     *
     * @return String
     */
    public function getValue(): String
    {
        return $this->value;
    }
}
