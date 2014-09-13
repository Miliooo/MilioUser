<?php

namespace Milio\User\Domain\Utils;

use Milio\User\Domain\ValueObjects\BasicUsername;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\StringUserId;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\User\Domain\Write\Event\UserRegisteredEvent;
use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\Write\Model\UserSecurity;

/**
 * Class TestUtils
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class TestUtils
{
    CONST USER_ID = '1';
    CONST USERNAME = 'username';
    CONST PASSWORD_HASH = 'hashed_password';
    CONST PASSWORD_SALT = 'this_is_the_salt';
    const EMAIL = 'foo@bar.com';
    const DATE_TIME = '10-10-2011 00:00:00';
    const ROLE_SIGNUP = 'ROLE_USER';

    /**
     * @return UserId
     */
    public static function getUserId()
    {
        return new StringUserId(self::USER_ID);
    }

    /**
     * @return BasicUsername
     */
    public static function getUsername()
    {
        return new BasicUsername(self::USERNAME);
    }

    /**
     * @return string
     */
    public static function getEmail()
    {
        return self::EMAIL;
    }

    /**
     * @return string
     */
    public static function getPassword()
    {
        return self::PASSWORD_HASH;
    }

    /**
     * @return string
     */
    public static function getSalt()
    {
        return self::PASSWORD_SALT;
    }



    /**
     * Gets a password value object.
     *
     * @return Password
     */
    public static function getPasswordVO()
    {
        return new Password(self::PASSWORD_HASH, self::PASSWORD_SALT);
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

    /**
     * @return UserRegisteredEvent
     */
    public static function getUserRegisteredEvent()
    {
        return new UserRegisteredEvent(
            self::USER_ID,
            self::USERNAME,
            self::getEmail(),
            self::PASSWORD_HASH,
            self::PASSWORD_SALT,
            self::getDateTime(),
            [self::ROLE_SIGNUP],
            UserSecurity::DEFAULT_ACCOUNT_STATUS
        );
    }
}
