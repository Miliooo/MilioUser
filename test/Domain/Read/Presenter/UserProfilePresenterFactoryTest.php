<?php

namespace Milio\User\Domain\Read\Presenter;
use Milio\User\Domain\Read\Model\ViewUserProfile;

/**
 * Class UserProfilePresenterFactoryTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserProfilePresenterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserProfilePresenterFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new UserProfilePresenterFactory();
    }
    /**
     * @test
     */
    public function it_can_add_presenters()
    {
        $test = new TestUserProfilePresenter();

        $this->factory->AddPresenter($test);
    }

    /**
     * @test
     */
    public function it_loads_the_presenter_based_on_the_account_status()
    {
        $userProfile = new ViewUserProfile();
        $userProfile->accountStatus = 'test';

        $this->factory->addPresenter(new TestUserProfilePresenter());

        $presenter = $this->factory->getPresenter($userProfile);

        $this->assertInstanceOf('Milio\User\Domain\Read\Presenter\TestUserProfilePresenter', $presenter);
    }
}


class TestUserProfilePresenter extends AbstractProfilePresenter
{
    public function getStatus()
    {
        return 'tester';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'test';
    }
}
