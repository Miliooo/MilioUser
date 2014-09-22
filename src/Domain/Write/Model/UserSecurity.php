<?php

namespace Milio\User\Domain\Write\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\Write\Event\AccountStatusUpdatedEvent;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\ValueObjects\Username;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;

/**
 * The user security model is used for logging in users. For giving them more or less rights.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserSecurity extends EventSourcedAggregateRoot
{
    CONST DEFAULT_ROLE = "ROLE_USER";
    CONST DEFAULT_ACCOUNT_STATUS = "active";

    CONST ACCOUNT_STATUS_ACTIVE = "active";
    CONST ACCOUNT_STATUS_LOCKED = "locked";
    CONST ACCOUNT_STATUS_DELETED = "deleted";
    CONST ACCOUNT_STATUS_AWAITING_CONFIRMATION = "aw_conf";
    CONST ACCOUNT_STATUS_EXPIRED = "expired";

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string The hashed password
     */
    protected $password;

    /**
     * @var string The salt
     */
    protected $salt;

    /**
     * @var \DateTime
     */
    protected $dateRegistered;

    /**
     * @var string One of the account status commands.
     */
    protected $accountStatus = self::DEFAULT_ACCOUNT_STATUS;

    /**
     * @var array
     */
    protected $roles = [];

    /**
     * @param UserId    $userId         The user id value object
     * @param Username  $username       The username value object (guards invalid names)
     * @param string    $email          The email
     * @param password  $password       The password value object
     * @param \DateTime $dateRegistered The date the user was registered
     *
     * @return UserSecurity
     */
    public static function registerUser(UserId $userId, Username $username, $email, password $password, \DateTime $dateRegistered)
    {
        $user =  new static();

        $user->apply(new UserRegisteredEvent(
            $userId->getIdentifierString(),
            $username->getUsername(),
            $email,
            $password->getHashedPassword(),
            $password->getSalt(),
            $dateRegistered,
            [self::DEFAULT_ROLE],
            self::DEFAULT_ACCOUNT_STATUS
            ));

        return $user;
    }

    /**
     * @param Username $username
     */
    public function changeUsername(Username $username)
    {
        if ($username->getUsername() === $this->username) {
            return;
        }

        $this->apply(new UsernameChangedEvent($this->userId, $this->username, $username->getUsername()));
    }

    /**
     * @param $status
     */
    public function updateAccountStatus($status)
    {
        if ($this->accountStatus === $status) {
            return;
        }

        $this->apply(new AccountStatusUpdatedEvent($this->userId, $this->accountStatus, $status));
    }

    /**
     * @param AccountStatusUpdatedEvent $event
     */
    public function applyAccountStatusUpdatedEvent(AccountStatusUpdatedEvent $event)
    {
        $this->accountStatus = $event->updated;
    }

    /**
     * @param UsernameChangedEvent $event
     */
    public function applyUserNameChangedEvent(UsernameChangedEvent $event)
    {
        $this->username = $event->getUpdatedUsername();
    }

    /**
     * @param UserRegisteredEvent $event
     */
    public function applyUserRegisteredEvent(UserRegisteredEvent $event)
    {
        $this->userId = (string) $event->userId;
        $this->username = $event->username;
        $this->email = $event->email;
        $this->password = $event->password;
        $this->salt = $event->salt;
        $this->dateRegistered = $event->dateRegistered;
        $this->roles = $event->roles;
        $this->accountStatus = $event->accountStatus;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string) $this->userId;
    }
}
