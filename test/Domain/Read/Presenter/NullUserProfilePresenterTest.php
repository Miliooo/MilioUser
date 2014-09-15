<?php

namespace Milio\User\Domain\Read\Presenter;

use Milio\User\Domain\Read\Presenter\Testing\ProfilePresenterTest;

/**
 * Class NullUserProfilePresenterTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class NullUserProfilePresenterTest extends ProfilePresenterTest
{
    /**
     * @return UserProfilePresenterInterface
     */
    public function getPresenter()
    {
        return new NullUserProfilePresenter();
    }
}
