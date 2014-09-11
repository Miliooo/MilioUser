<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Read\Model\ViewUserSecurity;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Write\Event\UserDeletedEvent;

/**
 * Class UserReadModelProjectorTestCase
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ViewUserSecurityModelProjectorTestCase extends ProjectorScenarioTestCase
{
    /**
     * @test
     */
    public function it_should_update_the_model()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $expectedUserModel = new ViewUserSecurity();
        $expectedUserModel->userId = (string) TestUtils::getUserId();
        $expectedUserModel->username = TestUtils::getUsername();
        $expectedUserModel->email = TestUtils::getEmail();
        $expectedUserModel->dateRegistered = TestUtils::getDateTime();
        $expectedUserModel->password = TestUtils::getPassword();
        $expectedUserModel->salt = TestUtils::getSalt();
        $expectedUserModel->roles = TestUtils::ROLE_SIGNUP;

        $this->scenario->given([$userRegisteredEvent])
            ->when($userRegisteredEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * @test
     */
    public function it_updates_the_username_when_username_changed_event()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $usernameChangedEvent = new UsernameChangedEvent(TestUtils::getUserId(), TestUtils::USERNAME, 'usernamenew');

        $expectedUserModel = new ViewUserSecurity();
        $expectedUserModel->userId = (string)TestUtils::getUserId();
        $expectedUserModel->username = 'usernamenew';
        $expectedUserModel->email = TestUtils::getEmail();
        $expectedUserModel->dateRegistered = TestUtils::getDateTime();
        $expectedUserModel->password = TestUtils::getPassword();
        $expectedUserModel->salt = TestUtils::getSalt();
        $expectedUserModel->roles = TestUtils::ROLE_SIGNUP;

        $this->scenario->given([$userRegisteredEvent, $usernameChangedEvent])
            ->when($usernameChangedEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * @test
     */
    public function it_updates_the_is_deleted_value_when_user_deleted_event()
    {
        $expectedUserModel = new ViewUserSecurity();
        $expectedUserModel->userId = (string)TestUtils::getUserId();
        $expectedUserModel->username = TestUtils::USERNAME;
        $expectedUserModel->email = TestUtils::getEmail();
        $expectedUserModel->dateRegistered = TestUtils::getDateTime();
        $expectedUserModel->password = TestUtils::getPassword();
        $expectedUserModel->salt = TestUtils::getSalt();
        $expectedUserModel->roles = TestUtils::ROLE_SIGNUP;
        $expectedUserModel->isDeleted = 1;

        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $userDeletedEvent = new UserDeletedEvent(TestUtils::USER_ID);

        $this->scenario->given([$userRegisteredEvent])
            ->when($userDeletedEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new ViewUserSecurityModelProjector($repository, 'Milio\User\Domain\Read\Model\ViewUserSecurity');
    }
}
