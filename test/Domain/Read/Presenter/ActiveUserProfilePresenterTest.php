<?php

namespace Milio\User\Domain\Read\Presenter;

use Milio\User\Domain\Read\Presenter\Testing\ProfilePresenterTest;

/**
 * Class ActiveUserProfilePresenterTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ActiveUserProfilePresenterTest extends ProfilePresenterTest
{
    /**
     * @return UserProfilePresenterInterface
     */
    public function getPresenter()
    {
        return new ActiveUserProfilePresenter();
    }
}
