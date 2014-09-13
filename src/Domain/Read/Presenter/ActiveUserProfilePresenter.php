<?php

namespace Milio\User\Domain\Read\Presenter;

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
}
