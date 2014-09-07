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
     * @param UserId    $userId
     * @param Username  $username
     * @param string    $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     */
    private function __construct(UserId $userId, Username $username, $email, Password $password, \DateTime $dateRegistered)
    {
        $this->userId = $userId->getUserId();
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->dateRegistered = $dateRegistered;
    }

    /**
     * @param           $userId
     * @param           $username
     * @param           $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     *
     * @return static
     */
    public static function registerUser(UserId $userId, Username $username, $email, $password, \DateTime $dateRegistered)
    {
        $user =  new self($userId, $username, $email, $password, $dateRegistered);

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
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->userId;
    }
}
