<?php

namespace Milio\User\Domain\Write\Command;

use Milio\User\Domain\ValueObjects\UserId;
use Milio\User\Domain\ValueObjects\Username;

/**
 * Class ChangeUsernameCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ChangeUsernameCommand
{
    /**
     * @var UserId
     */
    public $userId;

    /**
     * @var Username
     */
    public $username;

    /**
     * Constructor.
     *
     * @param UserId   $userId   The identifier for whom we update the username.
     * @param Username $username The new username
     */
    public function __construct(UserId $userId, Username $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }
}
