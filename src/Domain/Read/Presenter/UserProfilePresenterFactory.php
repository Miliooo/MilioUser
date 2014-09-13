<?php

namespace Milio\User\Domain\Read\Presenter;

use Milio\User\Domain\Read\Model\ViewUserProfile;

/**
 * Naive implementation of an user profile presenter.
 *
 * We allow to add presenters because they can be a service.
 *
 * This factory knows the name of the possible presenters.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserProfilePresenterFactory
{
    private $presenters = [];

    /**
     * @param ViewUserProfile $profile
     *
     * @return UserProfilePresenterInterface
     */
    public function getPresenter(ViewUserProfile $profile = null)
    {
        //handles no user view models. For example if your database has a reference to an userid which doesn't exist anymore.
        if ($profile === null) {
            return new NullUserProfilePresenter();
        }
    }

    /**
     * @param UserProfilePresenterInterface $presenter
     */
    public function AddPresenter(UserProfilePresenterInterface $presenter)
    {
        $this->presenters[$presenter->getName()] = $presenter;
    }
}
