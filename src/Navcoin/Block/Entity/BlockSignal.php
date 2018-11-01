<?php

namespace App\Navcoin\Block\Entity;

class BlockSignal
{
    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $description;

    /**
     * @var boolean
     */
    private $signalling;

    public function __construct(String $name, bool $signalling)
    {
        $this->name = $name;
        $this->signalling = $signalling;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getDescription(): String
    {
        return $this->description;
    }

    public function isSignalling(): bool
    {
        return $this->signalling;
    }
}
