<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;
use Broadway\ReadModel\RepositoryInterface;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Write\Event\AccountStatusUpdatedEvent;
use Milio\User\Domain\Read\Model\ViewUserProfile;

/**
 * Class ViewUserProfileModelProjector
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ViewUserProfileModelProjector extends Projector
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
        /** @var ViewUserProfile $model */
        $model = new $class();
        $model->userId = (string) $event->userId;
        $model->username = $event->username;
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
     * Helper function to get auto completion.
     *
     * @param string $userId
     *
     * @return ViewUserProfile
     */
    protected function retrieveModel($userId)
    {
        return $this->repository->find($userId);
    }
}
