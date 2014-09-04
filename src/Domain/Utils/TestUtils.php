<?php

namespace Milio\User\Domain\Utils;

use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\StringUserId;
use Milio\User\Domain\Write\Command\RegisterUserCommand;

/**
 * Class TestUtils
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class TestUtils
{
    CONST USER_ID = '1';
    CONST USERNAME = 'username';
    CONST PASSWORD = 'password';
    CONST PASSWORD_HASH = 'hashed_password';
    CONST PASSWORD_SALT = 'this_is_the_salt';
    const PASSWORD_PLAIN = '123456'; //yeah very safe password!
    const EMAIL = 'foo@bar.com';
    const DATE_TIME = '10-10-2011 00:00:00';

    /**
     * @return string
     */
    public static function getUserId()
    {
        return new StringUserId(self::USER_ID);
    }

    /**
     * Gets an string username.
     *
     * @return string
     */
    public static function getUsername()
    {
        return self::USERNAME;
    }

    /**
     * @return string
     */
    public static function getEmail()
    {
        return self::EMAIL;
    }

    /**
     * Gets a password value object.
     *
     * @return Password
     */
    public static function getPasswordVO()
    {
        return new Password(self::PASSWORD_HASH, self::PASSWORD_SALT, self::PASSWORD_PLAIN);
    }

    /**
     * @return \DateTime
     */
    public static function getDateTime()
    {
        return new \DateTime(self::DATE_TIME);
    }

    /**
     * @return RegisterUserCommand
     */
    public static function getRegisterUserCommand()
    {
        return new RegisterUserCommand(
            self::getUserId(),
            self::getUsername(),
            self::getEmail(),
            self::getPasswordVO(),
            self::getDateTime()
        );
    }
}
