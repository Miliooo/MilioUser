<?php

namespace Milio\User\Domain\Write\Event;

/**
 * Class UserRoleAddedEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRoleAddedEvent
{
    public $userId;
    public $userRole;

    /**
     * @param string $userId
     * @param string $userRole
     */
    public function __construct($userId, $userRole)
    {
        $this->userId = $userId;
        $this->userRole = $userRole;
    }
}
