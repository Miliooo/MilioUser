<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;
use Broadway\ReadModel\RepositoryInterface;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;

/**
 * The user read model projector is responsible for applying the events to the read model.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ViewUserSecurityModelProjector extends Projector
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $class;

    /**
     * Constructor.
     *
     * @param RepositoryInterface $repository
     * @param string              $class
     */
    public function __construct(RepositoryInterface $repository, $class)
    {
        $this->repository = $repository;
        $this->class = $class;
    }

    /**
     * Applies the user registered event.
     *
     * @param UserRegisteredEvent    $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUserRegisteredEvent(UserRegisteredEvent $event, DomainMessageInterface $domainMessage)
    {
        $class = $this->class;
        $model = new $class();
        $model->userId = (string) $event->getUserId();
        $model->username = $event->getUsername();
        $model->email = $event->getEmail();
        $model->password = $event->getPassword();
        $model->salt = $event->getSalt();
        $model->dateRegistered = $event->getDateRegistered();
        $model->roles = implode(' ', $event->getRoles());

        $this->repository->save($model);
    }

    /**
     * @param UsernameChangedEvent   $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUsernameChangedEvent(UsernameChangedEvent $event, DomainMessageInterface $domainMessage)
    {
        $model = $this->repository->find($event->getUserId());
        $model->username = $event->getUpdatedUsername();

        $this->repository->save($model);
    }
}