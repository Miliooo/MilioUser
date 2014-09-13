<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Read\Model\ViewUserSecurity;
use Milio\User\Domain\Write\Event\AccountStatusUpdatedEvent;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Write\Model\UserSecurity;

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
    public function it_creates_new_model_when_user_registered_event()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $expectedUserModel = $this->getModelWhenRegistered();

        $this->scenario->given([$userRegisteredEvent])
            ->when($userRegisteredEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * @test
     */
    public function it_updates_the_username_when_username_changed_event()
    {
        $newUsername = 'foo_bar';
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $usernameChangedEvent = new UsernameChangedEvent(TestUtils::getUserId(), TestUtils::USERNAME, $newUsername);
        $expectedUserModel = $this->getModelWhenRegistered();
        $expectedUserModel->username = $newUsername;


        $this->scenario->given([$userRegisteredEvent, $usernameChangedEvent])
            ->when($usernameChangedEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * @test
     */
    public function it_can_update_the_account_status()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $accountStatusUpdatedEvent = new AccountStatusUpdatedEvent(
            TestUtils::USER_ID,
            UserSecurity::ACCOUNT_STATUS_DELETED,
            UserSecurity::ACCOUNT_STATUS_ACTIVE);
        $expectedModel = $this->getModelWhenRegistered();
        $expectedModel->accountStatus = UserSecurity::ACCOUNT_STATUS_ACTIVE;

        $this->scenario->given([$userRegisteredEvent, $accountStatusUpdatedEvent])
            ->when($accountStatusUpdatedEvent)
            ->then([$expectedModel]);
    }

    /**
     * The expected user model when an user does an user registered event by using test utils.
     *
     * @return ViewUserSecurity
     */
    protected function getModelWhenRegistered()
    {
        $expectedUserModel = new ViewUserSecurity();
        $expectedUserModel->userId = (string)TestUtils::getUserId();
        $expectedUserModel->username = TestUtils::getUsername();
        $expectedUserModel->email = TestUtils::getEmail();
        $expectedUserModel->dateRegistered = TestUtils::getDateTime();
        $expectedUserModel->password = TestUtils::getPassword();
        $expectedUserModel->salt = TestUtils::getSalt();
        $expectedUserModel->roles = TestUtils::ROLE_SIGNUP;
        $expectedUserModel->accountStatus = UserSecurity::DEFAULT_ACCOUNT_STATUS;

        return $expectedUserModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new ViewUserSecurityModelProjector($repository, 'Milio\User\Domain\Read\Model\ViewUserSecurity');
    }
}
