<?php

namespace Milio\User\Domain\Read\Presenter;

/**
 * Interface UserProfilePresenterInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserProfilePresenterInterface
{
    /**
     * @param null $userProfile
     *
     * @return mixed
     */
    public function getData($userProfile = null);

    /**
     * @return string
     */
    public function getName();
}
