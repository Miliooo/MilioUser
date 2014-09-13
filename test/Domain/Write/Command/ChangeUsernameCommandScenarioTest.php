<?php

namespace Milio\User\Domain\Write\Command;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Milio\User\Domain\ValueObjects\BasicUsername;
use Milio\User\Domain\Write\Event\UsernameChangedEvent;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Handler\SecurityUserCommandHandler;
use Milio\User\Domain\Utils\TestUtils;

/**
 * Class ChangeUsernameCommandScenarioTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ChangeUsernameCommandScenarioTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function username_can_be_changed()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $changeUsernameCommand = new ChangeUsernameCommand(TestUtils::getUserId(), new BasicUsername('updated_username'));

        $usernameChangedEvent = new UsernameChangedEvent(testUtils::getUserId(), testUtils::getUsername()->getUsername(), 'updated_username');

        $this->scenario
            ->given([$registerEvent])
            ->when($changeUsernameCommand)
            ->then([$usernameChangedEvent]);
    }

    /**
     * @test
     */
    public function changing_to_the_same_username_yields_no_change()
    {
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $changeUsernameCommand = new ChangeUsernameCommand(TestUtils::getUserId(), new BasicUsername('updated_username'));

        $usernameChangedEvent = new UsernameChangedEvent(testUtils::getUserId(), testUtils::getUsername()->getUsername(), 'updated_username');

        $this->scenario
            ->given([$registerEvent, $usernameChangedEvent])
            ->when($changeUsernameCommand)
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
