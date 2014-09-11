<?php

namespace Milio\User\Domain\Read\Repository;

use Broadway\ReadModel\RepositoryFactoryInterface;
use Broadway\ReadModel\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineORMRepositoryFactory
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DoctrineORMRepositoryFactory implements RepositoryFactoryInterface
{
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $name
     * @param string $class
     *
     * @return RepositoryInterface
     */
    public function create($name, $class)
    {
        return new DoctrineORMRepository($this->entityManager, $class);
    }
}
