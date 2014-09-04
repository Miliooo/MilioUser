<?php

namespace Milio\User\Write\Command;

use Milio\User\ValueObjects\UserId;
use Milio\User\ValueObjects\Password;

/**
 * Those properties are public for the moment since we want the form to be able to populate this.
 *
 * That way we can use the validator to validate those commands.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserCommand
{
    /**
     * The userId value object.
     *
     * @var UserId
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
     * @var Password
     */
    public $password;

    /**
     * @var \DateTime
     */
    public $dateRegistered;

    /**
     * Constructor.
     *
     * @param UserId    $userId
     * @param string    $username
     * @param string    $email
     * @param Password  $password
     * @param \DateTime $dateRegistered
     */
    public function __construct(UserId $userId, $username, $email, Password $password, \DateTime $dateRegistered)
    {
        $this->userId = $userId;
        $this->username= $username;
        $this->email = $email;
        $this->password = $password;
        $this->dateRegistered = $dateRegistered;
    }
}
