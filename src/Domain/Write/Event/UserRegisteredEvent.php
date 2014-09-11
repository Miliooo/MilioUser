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
    private $userId;
    private $username;
    private $email;
    private $password;
    private $salt;
    private $dateRegistered;
    private $roles = [];

    /**
     * @param string    $userId         String UserId
     * @param string    $username       String username
     * @param string    $email          String email
     * @param string    $password       String password
     * @param string    $salt           String salt
     * @param \DateTime $dateRegistered \DateTime
     * @param array     $roles          The roles the user has.
     */
    public function __construct($userId, $username, $email, $password, $salt, \DateTime $dateRegistered, array $roles)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->dateRegistered = $dateRegistered;
        $this->roles = $roles;
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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return string
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
     * Gets the roles the user has when he's registered.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username;
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
            $data['roles']
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
            'roles' => $this->roles
        ];
    }
}
