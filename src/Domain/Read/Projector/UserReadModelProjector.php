<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;
use Broadway\ReadModel\RepositoryInterface;
use Milio\User\Domain\Read\Model\UserRead;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;

/**
 * The user read model projector is responsible for applying the events to the read model.
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
     * Constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Applies the user registered event.
     *
     * @param                        $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUserRegisteredEvent(UserRegisteredEvent $event, DomainMessageInterface $domainMessage)
    {
        $model = new UserRead();
        $model->id = (string) $event->getUserId();
        $model->username = $event->getUsername();
        $model->password = $event->getPassword()->getHashedPassword();
        $model->dateRegistered = $event->getDateRegistered();
        $this->repository->save($model);
    }
}
