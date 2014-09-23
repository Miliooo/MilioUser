<?php

namespace Milio\User\Domain\Write\Command;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Milio\User\Domain\Write\Event\UserRoleAddedEvent;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Handler\SecurityUserCommandHandler;
use Milio\User\Domain\Utils\TestUtils;

/**
 * Class AddUserRoleCommandScenarioTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddUserRoleCommandScenarioTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function user_roles_can_be_added()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $addRoleCommand = new AddUserRoleCommand(TestUtils::getUserId(), 'ROLE_ADMIN');
        $roleAddedEvent = new UserRoleAddedEvent(TestUtils::USER_ID, 'ROLE_ADMIN');

        $this->scenario
            ->given([$registerEvent])
            ->when($addRoleCommand)
            ->then([$roleAddedEvent]);
    }

    /**
     * @test
     */
    public function adding_an_existing_user_role_yields_no_change()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $addRoleCommand = new AddUserRoleCommand(TestUtils::getUserId(), 'ROLE_ADMIN');
        $roleAddedEvent = new UserRoleAddedEvent(TestUtils::USER_ID, 'ROLE_ADMIN');

        $this->scenario
            ->given([$registerEvent, $roleAddedEvent])
            ->when($addRoleCommand)
            ->then([]);
    }

    /**
     * Create a command handler for the given scenario test case.
     *
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface   $eventBus
     *
     * @return CommandHandlerInterface
     */
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        $repository = new UserWriteEventSourcingRepository($eventStore, $eventBus, 'Milio\User\Domain\Write\Model\UserSecurity');
        return new SecurityUserCommandHandler($repository, 'Milio\User\Domain\Write\Model\UserSecurity');
    }
}
