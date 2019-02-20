<?php

namespace App\Navcoin\Common\Mapper;

use App\Navcoin\Common\Entity\Paginator;

interface MapperInterface
{
    public function mapEntity(array $data);
    public function mapIterator(String $class, array $data, Paginator $paginator = null, array $options = []);
}
