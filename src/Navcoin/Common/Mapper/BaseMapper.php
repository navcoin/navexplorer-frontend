<?php

namespace App\Navcoin\Common\Mapper;

use App\Navcoin\Common\Entity\Paginator;

abstract class BaseMapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $options;

    abstract function mapEntity(array $data);

    public function mapIterator(String $class, array $data, Paginator $paginator = null, array $options = [])
    {
        $this->options = $options;

        $container = $paginator !== null ? $paginator : new $class;

        foreach ($this->getElements($data) as $entity) {
            $element = $this->mapEntity($entity);

            if ($element !== null) {
                $container->add($element);

            }
        }

        return $container;
    }

    protected function getElements(array $data): array
    {
        if ($this->isPaginated($data)) {
            return $data['content'];
        }

        return $data;
    }

    protected function isPaginated(array $data): bool
    {
        return array_key_exists('content', $data);
    }

    protected function getData($field, $data, $default = null)
    {
        if ($this->hasData($field, $data)) {
            return $data[$field];
        }

        return $default;
    }

    protected function hasData($field, $data): bool
    {
        return array_key_exists($field, $data);
    }
}
