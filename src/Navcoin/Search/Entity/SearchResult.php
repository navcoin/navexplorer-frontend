<?php

namespace App\Navcoin\Search\Entity;

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

    public function __construct(String $type, String $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType(): String
    {
        return $this->type;
    }

    public function getValue(): String
    {
        return $this->value;
    }
}
