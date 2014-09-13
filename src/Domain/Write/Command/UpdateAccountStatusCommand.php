<?php

namespace Milio\User\Domain\Write\Command;

use Milio\User\Domain\ValueObjects\UserId;

/**
 * Account status means in the security context here. It has nothing to do with being a premium member.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UpdateAccountStatusCommand
{
    /**
     * @var UserId
     */
    public $userId;

    /**
     * @var string One of the account status constants.
     */
    public $status;

    /**
     * @param UserId $userId
     * @param string $status
     */
    public function __construct(UserId $userId, $status)
    {
        $this->userId = $userId;
        $this->status = $status;
    }
}
