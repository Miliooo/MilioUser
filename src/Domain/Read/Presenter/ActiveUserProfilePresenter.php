<?php

namespace Milio\User\Domain\Read\Presenter;

use Milio\User\Domain\Write\Model\UserSecurity;

/**
 * Class ActiveUserProfilePresenter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ActiveUserProfilePresenter extends AbstractProfilePresenter
{
    /**
     * @return string
     */
    public function getStatus()
    {
        return 'active';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return UserSecurity::ACCOUNT_STATUS_ACTIVE;
    }
}
