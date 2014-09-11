<?php

namespace Milio\User\Domain\Write\Command;

use Milio\User\Domain\ValueObjects\UserId;

/**
 * Class DeleteUserCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteUserCommand
{
    public $userId;

    /**
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }
}
