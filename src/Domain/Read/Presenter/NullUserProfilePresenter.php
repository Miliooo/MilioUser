<?php

namespace Milio\User\Domain\Read\Presenter;


/**
 * Class NullUserProfilePresenter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class NullUserProfilePresenter extends AbstractProfilePresenter
{
    /**
     * @return string
     */
    public function getUsername()
    {
        return 'Anonymous';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return 'Removed';
    }
}
