<?php

namespace Milio\User\ValueObjects;

/**
 * Password value object.
 *
 * @todo we DONT want to store plainpasswords!!!!!
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
     * @var string
     */
    private $plainPassword;

    /**
     * @param        $hashedPassword
     * @param        $salt
     * @param string $plainPassword
     */
    public function __construct($hashedPassword, $salt, $plainPassword = '')
    {
        $this->guardMaximumLength($plainPassword);
        $this->plainPassword = $plainPassword;
        $this->salt = $salt;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
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

    /**
     * Guards that a password does not exceed a certain length. Security problem...
     *
     * @param string $plainPassword
     *
     * @throws \InvalidArgumentException
     */
    private function guardMaximumLength($plainPassword)
    {
        if ($plainPassword && mb_strlen($plainPassword) > 4000) {
            throw new \InvalidArgumentException('Password too long');
        }
    }
}

