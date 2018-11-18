<?php

namespace App\Navcoin\Common\Mapper;

use App\Navcoin\Common\Entity\Paginator;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

abstract class BaseMapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $options;

    abstract function mapEntity(array $data);

    public function mapIterator(array $data, String $class = null, array $options = []): IteratorEntityInterface
    {
        $this->options = $options;

        $container = $this->isPaginated($data) ? $this->createPaginator($data, $class) : new $class;

        foreach ($this->getElements($data) as $entity) {
            $container->add($this->mapEntity($entity));
        }

        return $container;
    }

    protected function createPaginator(array $data, string $class): Paginator
    {
        return (new Paginator())
            ->setLast($data['last'])
            ->setTotalPages($data['totalPages'])
            ->setTotalElements($data['totalElements'])
            ->setFirst($data['first'])
            ->setNumberOfElements($data['numberOfElements'])
            ->setSize($data['size'])
            ->setNumber($data['number'])
            ->setElements(new $class);
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
}
