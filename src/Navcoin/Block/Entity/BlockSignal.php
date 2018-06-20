<?php

namespace App\Navcoin\Block\Entity;

/**
 * Class BlockSignal
 *
 * @package App\Navcoin\Block\Entity
 */
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

    /**
     * Constructor
     *
     * @param String $name
     * @param bool   $signalling
     */
    public function __construct(String $name, bool $signalling)
    {
        $this->name = $name;
        $this->signalling = $signalling;
    }

    /**
     * Get Name
     *
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * Get Description
     *
     * @return String
     */
    public function getDescription(): String
    {
        return $this->description;
    }

    /**
     * Get Signalling
     *
     * @return bool
     */
    public function isSignalling(): bool
    {
        return $this->signalling;
    }
}
