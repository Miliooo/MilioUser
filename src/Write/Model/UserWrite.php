<?php

namespace Milio\User\Write\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Milio\User\ValueObjects\Password;
use Milio\User\ValueObjects\UserId;
use Milio\User\Write\Event\UserRegisteredEvent;

/**
 * Class User
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserWrite extends EventSourcedAggregateRoot
{
    /**
     * @var UserId
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
     * @var string
     */
    protected $hashedPassword;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var \DateTime
     */
    protected $dateRegistered;

    /**
     *
     * To consider, do we need this constructor.
     *
     * @param UserId    $userId
     * @param           $username
     * @param           $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     */
    private function __construct(UserId $userId, $username, $email, Password $password, \DateTime $dateRegistered)
    {
        $this->userId = $userId;
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
    public static function registerUser(UserId $userId, $username, $email,  $password, \DateTime $dateRegistered)
    {
        $user =  new self($userId, $username, $email, $password, $dateRegistered);
        $user->apply(new UserRegisteredEvent($userId, $username, $email, $password, $dateRegistered));

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
        $this->hashedPassword = $event->getPassword()->getHashedPassword();
        $this->salt = $event->getPassword()->getSalt();
        $this->dateRegistered = $event->getDateRegistered();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->userId->__toString();
    }
}
