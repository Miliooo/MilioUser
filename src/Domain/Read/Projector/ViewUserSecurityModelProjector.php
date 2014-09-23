<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;
use Broadway\ReadModel\RepositoryInterface;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Read\Model\ViewUserSecurity;
use Milio\User\Domain\Write\Event\AccountStatusUpdatedEvent;
use Milio\User\Domain\Write\Event\UserRoleAddedEvent;

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
    protected $repository;

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
        $model->userId = (string) $event->userId;
        $model->username = $event->username;
        $model->email = $event->email;
        $model->password = $event->password;
        $model->salt = $event->salt;
        $model->dateRegistered = $event->dateRegistered;
        $model->roles = implode(' ', $event->roles);
        $model->accountStatus = $event->accountStatus;

        $this->repository->save($model);
    }

    /**
     * @param UsernameChangedEvent   $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUsernameChangedEvent(UsernameChangedEvent $event, DomainMessageInterface $domainMessage)
    {
        $model = $this->retrieveModel($event->getUserId());
        $model->username = $event->getUpdatedUsername();

        $this->repository->save($model);
    }

    /**
     * @param AccountStatusUpdatedEvent $event
     * @param DomainMessageInterface    $domainMessage
     */
    public function applyAccountStatusUpdatedEvent(AccountStatusUpdatedEvent $event, DomainMessageInterface $domainMessage)
    {
        $model = $this->retrieveModel($event->userId);
        $model->accountStatus = $event->updated;
        $this->repository->save($model);
    }

    /**
     * To consider,is this really the best way?
     * @param UserRoleAddedEvent $event
     */
    public function applyUserRoleAddedEvent(UserRoleAddedEvent $event)
    {
        $model = $this->retrieveModel($event->userId);

        $rolesArray = $model->getRoles();
        //make sure to not save duplicates
        if (in_array($event->userRole, $rolesArray, true)) {
            return;
        }
        $rolesArray[] = $event->userRole;
        $roles = implode(' ', $rolesArray);
        $model->roles = $roles;
        $this->repository->save($model);
    }

    /**
     * Helper function to get auto completion.
     *
     * @param string $userId
     *
     * @return ViewUserSecurity
     */
    protected function retrieveModel($userId)
    {
        return $this->repository->find($userId);
    }
}
