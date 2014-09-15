<?php

namespace Milio\User\Domain\Read\Presenter\Testing;

use Milio\User\Domain\Read\Presenter\UserProfilePresenterInterface;

/**
 * Class ProfilePresenterTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class ProfilePresenterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_the_right_interface()
    {
        $this->assertInstanceOf('Milio\User\Domain\Read\Presenter\UserProfilePresenterInterface', $this->getPresenter());
    }

    /**
     * @return UserProfilePresenterInterface
     */
    abstract public function getPresenter();
}
