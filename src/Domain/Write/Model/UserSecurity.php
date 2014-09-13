<?php

namespace Milio\User\Domain\Write\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\ValueObjects\Username;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Write\Event\UserDeletedEvent;

/**
 * The user security model is used for logging in users. For giving them more or less rights.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserSecurity extends EventSourcedAggregateRoot
{
    CONST DEFAULT_ROLE = "ROLE_USER";

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
     * @var bool
     */
    protected $isDeleted = false;

    /**
     * @var bool
     */
    protected $isBanned = false;

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
            $userId->getUserId(),
            $username->getUsername(),
            $email,
            $password->getHashedPassword(),
            $password->getSalt(),
            $dateRegistered,
            [static::DEFAULT_ROLE]
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
     * @param UserId $userId
     */
    public function deleteUser(UserId $userId)
    {
        if ($this->isDeleted) {
            return;
        }

        $this->apply(new UserDeletedEvent($userId));
    }

    /**
     * @param UserDeletedEvent $event
     */
    public function applyUserDeletedEvent(UserDeletedEvent $event)
    {
        $this->isDeleted = true;
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
        $this->userId = $event->getUserId();
        $this->username = $event->getUsername();
        $this->email = $event->getEmail();
        $this->password = $event->getPassword();
        $this->salt = $event->getSalt();
        $this->dateRegistered = $event->getDateRegistered();
        $this->roles = static::DEFAULT_ROLE;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->userId;
    }
}
