<?php

namespace Milio\User\ValueObjects;

/**
 * Password value object.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Password
{
    /**
     * @var string
     */
    private $hashedPassword;

    /**
     * @var string
     */
    private $salt;

    /**
     * @param string $hashedPassword The hashed password
     * @param string $salt           The salt
     */
    public function __construct($hashedPassword, $salt)
    {
        $this->salt = $salt;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Gets the hashed password.
     *
     * @return string
     */
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    /**
     * Gets the salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
}

