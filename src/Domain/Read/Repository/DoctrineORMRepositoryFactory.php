<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

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
