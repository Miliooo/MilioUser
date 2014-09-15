<?php

namespace Milio\User\Domain\Read\Presenter;

/**
 * This should not happen but imagine an identifier which does no longer link to an user.
 *
 * Instead of a fatal we could handle it by presenting a nullUserProfile
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class NullUserProfilePresenter extends AbstractProfilePresenter
{
    /**
     * Need to overwrite this since we don't have an object.
     *
     * @return string
     */
    public function getId()
    {
        return '';
    }

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

    /**
     * @return string
     */
    public function getName()
    {
        return 'null';
    }
}
