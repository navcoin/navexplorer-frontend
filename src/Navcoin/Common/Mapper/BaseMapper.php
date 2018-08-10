<?php

namespace App\Navcoin\Common\Mapper;

use App\Navcoin\Common\Entity\Paginator;
use App\Navcoin\Common\Entity\IteratorEntityInterface;

/**
 * Class BaseMapper
 *
 * @package App\Navcoin\Common
 */
abstract class BaseMapper implements MapperInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    abstract function mapEntity(array $data);

    /**
     * Map blocks
     *
     * @param array  $data
     * @param string $class
     *
     * @return IteratorEntityInterface
     */
    public function mapIterator(array $data, String $class = null): IteratorEntityInterface
    {
        $container = $this->isPaginated($data) ? $this->createPaginator($data, $class) : new $class;

        foreach ($this->getElements($data) as $entity) {
            $element = $this->mapEntity($entity);

            if ($element !== null) {
                $container->add($element);

            }
        }

        return $container;
    }

    /**
     * Create Paginator
     *
     * @param array  $data
     * @param string $class
     *
     * @return Paginator
     */
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

    /**
     * Get Elements
     *
     * @param array $data
     *
     * @return array
     */
    protected function getElements(array $data): array
    {
        if ($this->isPaginated($data)) {
            return $data['content'];
        }

        return $data;
    }

    /**
     * Is Paginated
     *
     * @param array $data
     *
     * @return bool
     */
    protected function isPaginated(array $data): bool
    {
        return array_key_exists('content', $data);
    }
}
