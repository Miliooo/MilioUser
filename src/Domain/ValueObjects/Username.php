<?php

namespace Milio\User\Domain\ValueObjects;

use Milio\User\Domain\ValueObjects\Exceptions\UsernameException;

/**
 * Username value object.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class Username
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @param string $username
     *
     * @throws UserNameException
     */
    public function __construct($username)
    {
        $this->guardString($username);
        $username = trim($username);
        $this->guardMinLength($username);
        $this->guardMaxLength($username);

        $this->username = $username;
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

    /**
     * @param $username
     *
     * @throws UsernameException
     */
    protected function guardMinLength($username)
    {
        $length = $this->getLength($username);

        if ($length < 2) {
            throw new UsernameException('at least 2 characters');
        }
    }

    /**
     * @param $username
     *
     * @throws Exceptions\UsernameException
     */
    protected function guardMaxLength($username)
    {
        $length = $this->getLength($username);

        if($length > 25) {
            throw new UsernameException('max 25 characters');
        }
    }

    /**
     * @param string $username
     * @param string $charSet defaults to UTF-8
     *
     * @return integer
     */
    protected function getLength($username, $charSet = 'UTF-8')
    {
        if (function_exists('mb_strlen')) {
            $length = mb_strlen($username, $charSet);
        } else {
            $length = strlen($username);
        }

        return $length;
    }

    /**
     * @param $username
     *
     * @throws UserNameException
     */
    private function guardString($username)
    {
        if(!is_string($username)) {
            throw new UserNameException('username is not a string');
        }
    }
}
