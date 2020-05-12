<?php

namespace App\Navcoin\Dao\Entity;

class ConsensusParameter
{
    /** @var int */
    private $id;

    /** @var string */
    private $desc;

    /** @var int */
    private $type;

    /** @var int */
    private $value;

    /** @var int */
    private $updatedOnBlock;

    public function __construct(int $id, string $desc, int $type, int $value, int $updatedOnBlock)
    {
        $this->id = $id;
        $this->desc = $desc;
        $this->type = $type;
        $this->value = $value;
        $this->updatedOnBlock = $updatedOnBlock;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getFormattedValue()
    {
        switch ($this->type) {
            case 0:
                return $this->value;
            case 1:
                return $this->value / 100 . '%';
            case 2:
                return $this->value/10000000 . '&nbsp;Nav';
            case 3:
                return $this->value == 0 ? 'false' : 'true';
        }
    }

    public function getUpdatedOnBlock(): int
    {
        return $this->updatedOnBlock;
    }
}