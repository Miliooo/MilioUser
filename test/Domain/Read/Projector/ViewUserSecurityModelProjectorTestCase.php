<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Read\Model\ViewUserSecurity;

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
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new ViewUserSecurityModelProjector($repository, 'Milio\User\Domain\Read\Model\ViewUserSecurity');
    }
}