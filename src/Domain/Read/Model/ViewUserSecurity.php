<?php

namespace Milio\User\Domain\Read\Model;

use Broadway\ReadModel\ReadModelInterface;

/**
 * User Read model
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ViewUserSecurity implements ReadModelInterface
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $userId;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string The hashed password
     */
    public $password;

    /**
     * @var string salt.
     */
    public $salt;

    /**
     * @var \DateTime
     */
    public $dateRegistered;

    /**
     * @var string (space separated string with the roles the user has.)
     */
    public $roles;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->userId;
    }

    /**
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string The password
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
     * @return array
     */
    public function getRoles()
    {
        return preg_split('/\s+/', $this->roles);
    }

    /**
     * @return \DateTime
     */
    public function getDateRegistered()
    {
        return $this->dateRegistered;
    }
}