<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\SerializableInterface;

/**
 * User registered event.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRegisteredEvent implements SerializableInterface
{
    public $userId;
    public $username;
    public $email;
    public $password;
    public $salt;
    public $dateRegistered;
    public $roles = [];
    public $accountStatus;

    /**
     * @param string    $userId         String UserId
     * @param string    $username       String username
     * @param string    $email          String email
     * @param string    $password       String password
     * @param string    $salt           String salt
     * @param \DateTime $dateRegistered \DateTime
     * @param array     $roles          The roles the user has.
     * @param string    $accountStatus  The current account status
     */
    public function __construct($userId, $username, $email, $password, $salt, \DateTime $dateRegistered, array $roles, $accountStatus)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->dateRegistered = $dateRegistered;
        $this->roles = $roles;
        $this->accountStatus = $accountStatus;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        $date = new \DateTime();
        $dateTimeFromTimestamp = $date->setTimestamp($data['date_registered']);

        return new self(
            $data['userId'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['salt'],
            $dateTimeFromTimestamp,
            $data['roles'],
            $data['account_status']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return [
            'userId' => $this->userId,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'salt' => $this->salt,
            'date_registered' => $this->dateRegistered->getTimestamp(),
            'roles' => $this->roles,
            'account_status' => $this->accountStatus
        ];
    }
}
