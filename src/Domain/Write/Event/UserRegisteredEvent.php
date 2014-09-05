<?php

namespace Milio\User\Domain\Write\Event;

use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\ValueObjects\Password;

/**
 * User registered event.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRegisteredEvent
{
    private $userId;
    private $username;
    private $email;
    private $password;
    private $dateRegistered;

    /**
     * @param UserId    $userId
     * @param           $username
     * @param           $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     */
    public function __construct(UserId $userId, $username, $email, Password $password, \DateTime $dateRegistered)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->dateRegistered = $dateRegistered;
    }

    /**
     * @return \DateTime
     */
    public function getDateRegistered()
    {
        return $this->dateRegistered;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }
}
