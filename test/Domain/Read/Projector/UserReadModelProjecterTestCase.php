<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

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
    public function testIt()
    {
        $userRegisteredEvent = TestUtils::getUserRegisteredEvent();
        $expectedUserModel = new UserRead();
        $expectedUserModel->name = TestUtils::getUsername();

        $this->scenario->given([$userRegisteredEvent])
            ->when($userRegisteredEvent)
            ->then([$expectedUserModel]);
    }

    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new UserReadModelProjector($repository);
    }
}
