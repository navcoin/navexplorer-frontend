<?php

namespace App\Navcoin\Common\Mapper;

/**
 * Interface MapperInterface
 *
 * @package App\Navcoin\Common\Mapper
 */
interface MapperInterface
{
    public function mapEntity(array $data);
    public function mapIterator(array $data, String $class = null);
}
