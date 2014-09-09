<?php

namespace Milio\User\Domain\Write\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\ValueObjects\Username;

/**
 * Class User
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserWrite extends EventSourcedAggregateRoot
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
     * @var array
     */
    protected $roles = [];

    /**
     * @param UserId    $userId
     * @param Username  $username
     * @param           $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     * @param string   $role
     */
    private function __construct(UserId $userId, Username $username, $email, Password $password, \DateTime $dateRegistered, $role)
    {
        $this->userId = $userId->getUserId();
        $this->username = $username->getUsername();
        $this->email = $email;
        $this->password = $password->getHashedPassword();
        $this->salt = $password->getSalt();
        $this->dateRegistered = $dateRegistered;
        $this->roles = [$role];
    }

    /**
     * @param UserId    $userId         The user id value object
     * @param Username  $username       The username value object (guards invalid names)
     * @param string    $email          The email
     * @param password  $password       The password value object
     * @param \DateTime $dateRegistered The date the user was registered
     *
     * @return self
     */
    public static function registerUser(UserId $userId, Username $username, $email, password $password, \DateTime $dateRegistered)
    {
        $user =  new self($userId, $username, $email, $password, $dateRegistered, static::DEFAULT_ROLE);

        $user->apply(new UserRegisteredEvent(
            $userId->getUserId(),
            $username->getUsername(),
            $email,
            $password->getHashedPassword(),
            $password->getSalt(),
            $dateRegistered));

        return $user;
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
