<?php

namespace Milio\User\Domain\Write\Event;

/**
 * Class UserDeletedEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserDeletedEvent
{
    public $userId;

    /**
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
