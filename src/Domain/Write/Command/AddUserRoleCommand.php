<?php

namespace Milio\User\Domain\Write\Command;

use Milio\User\Domain\ValueObjects\UserId;

/**
 * Add an user role to the given user id.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddUserRoleCommand extends AbstractUserCommand
{
    /**
     * @var UserId
     */
    public $userId;

    /**
     * @var string
     */
    public $userRole;

    /**
     * Constructor.
     *
     * @param UserId $userId
     * @param        $userRole
     */
    public function __construct(UserId $userId, $userRole)
    {
        $this->userId = $userId;
        $this->userRole = $userRole;
    }
}
