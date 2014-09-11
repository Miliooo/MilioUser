<?php

namespace Milio\User\Domain\Write\Command;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Milio\User\Domain\Write\Event\UserDeletedEvent;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Handler\SecurityUserCommandHandler;
use Milio\User\Domain\Utils\TestUtils;

/**
 * Class DeleteUserCommandScenarioTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteUserCommandScenarioTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function it_can_delete__an_user()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $deleteUserCommand = new DeleteUserCommand(TestUtils::getUserId());
        $deleteEvent = new UserDeletedEvent(TestUtils::getUserId());

        $this->scenario
            ->given([$registerEvent])
            ->when($deleteUserCommand)
            ->then([$deleteEvent]);
    }

    /**
     * @test
     */
    public function deleting_an_deleted_user_yields_no_change()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $deleteUserCommand = new DeleteUserCommand(TestUtils::getUserId());
        $deleteEvent = new UserDeletedEvent(TestUtils::getUserId());

        $this->scenario
            ->given([$registerEvent, $deleteEvent])
            ->when($deleteUserCommand)
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
