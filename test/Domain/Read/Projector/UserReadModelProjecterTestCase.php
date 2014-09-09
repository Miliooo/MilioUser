<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Read\Model\UserRead;

/**
 * Class UserReadModelProjectorTestCase
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserReadModelProjectorTestCase extends ProjectorScenarioTestCase
{
    /**
     * @test
     */
    public function it_should_update_the_model()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $expectedUserModel = new UserRead();
        $expectedUserModel->userId = (string) TestUtils::getUserId();
        $expectedUserModel->username = TestUtils::getUsername();
        $expectedUserModel->email = TestUtils::getEmail();
        $expectedUserModel->dateRegistered = TestUtils::getDateTime();
        $expectedUserModel->password = TestUtils::getPassword();
        $expectedUserModel->salt = TestUtils::getSalt();

        $this->scenario->given([$userRegisteredEvent])
            ->when($userRegisteredEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new UserReadModelProjector($repository, 'Milio\User\Domain\Read\Model\UserRead');
    }
}
