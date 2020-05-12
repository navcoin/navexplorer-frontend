<?php

namespace App\Navcoin\CommunityFund\Entity;

class Voter
{
    /**
     * @var int
     */
    private $cycle;

    /**
     * @var int
     */
    private $yes;

    /**
     * @var int
     */
    private $no;

    /**
     * @var int
     */
    private $abstain;

    /**
     * @var VoterAddress[]
     */
    private $addresses;

    public function __construct(int $cycle, int $yes, int $no, int $abstain)
    {
        $this->cycle = $cycle;
        $this->yes = $yes;
        $this->no = $no;
        $this->abstain = $abstain;
    }

    public function getCycle(): int
    {
        return $this->cycle;
    }

    public function getYes(): int
    {
        return $this->yes;
    }

    public function getNo(): int
    {
        return $this->no;
    }

    public function getAbstain(): int
    {
        return $this->abstain;
    }

    public function getTotal(): int
    {
        return $this->yes + $this->no + $this->abstain;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function setAddresses(array $addresses)
    {
        $this->addresses = $addresses;
    }

    public function sortAddressesYesDesc() {
        $addresses = $this->getAddresses();
        usort( $addresses, function (VoterAddress $a, VoterAddress $b) {
            return -1 * ($a->getYes() - $b->getYes());
        });

        $this->setAddresses($addresses);
    }

    public function sortAddressesNoDesc() {
        $addresses = $this->getAddresses();
        usort( $addresses, function (VoterAddress $a, VoterAddress $b) {
            return -1 * ($a->getNo() - $b->getNo());
        });

        $this->setAddresses($addresses);
    }
}
