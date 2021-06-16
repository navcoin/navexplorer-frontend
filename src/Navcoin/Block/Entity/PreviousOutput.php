<?php

namespace App\Navcoin\Block\Entity;

class PreviousOutput
{
    /** @var int */
    private $height;

    /** @var string */
    private $type;

    /** @var MultiSig */
    private $multiSig;

    /** @var boolean */
    private $private;

    /** @var boolean */
    private $wrapped;

    public function __construct(int $height, string $type, ?MultiSig $multiSig, bool $private, bool $wrapped)
    {
        $this->height = $height;
        $this->type = $type;
        if ($multiSig !== null) {
            $this->multiSig = $multiSig;
        }
        $this->private = $private;
        $this->wrapped = $wrapped;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMultiSig(): ?MultiSig
    {
        return $this->multiSig;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function isWrapped(): bool
    {
        return $this->wrapped;
    }

    public function isMultiSig(): bool
    {
        return $this->multiSig != null;
    }
}