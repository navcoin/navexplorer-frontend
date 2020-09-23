<?php


namespace App\Navcoin\Address\Entity;


class SummaryAccount
{
    /** @var float */
    private $balance;

    /** @var float */
    private $staked;

    /** @var float */
    private $sent;

    /** @var float */
    private $received;

    public function __construct(float $balance, float $staked, float $sent, float $received)
    {
        $this->balance = $balance;
        $this->staked = $staked;
        $this->sent = $sent;
        $this->received = $received;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getStaked(): float
    {
        return $this->staked;
    }

    public function getSent(): float
    {
        return $this->sent;
    }

    public function getReceived(): float
    {
        return $this->received;
    }

}