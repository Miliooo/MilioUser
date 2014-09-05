<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;
use Broadway\ReadModel\RepositoryInterface;
use Milio\User\Domain\Read\Model\UserRead;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;

/**
 * Class UserReadModelProjector
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserReadModelProjector extends Projector
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param                        $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUserRegisteredEvent(UserRegisteredEvent $event, DomainMessageInterface $domainMessage)
    {
        $model = new UserRead();
        $model->name = $event->getUsername();

        $this->repository->save($model);
    }
}
