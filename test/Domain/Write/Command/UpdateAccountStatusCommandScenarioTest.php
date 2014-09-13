<?php

namespace Milio\User\Domain\Write\Command;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Milio\User\Domain\Write\Event\AccountStatusUpdatedEvent;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Handler\SecurityUserCommandHandler;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Write\Model\UserSecurity;

/**
 * Class UpdateAccountStatusCommandScenarioTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UpdateAccountStatusCommandScenarioTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function it_can_update_the_status()
    {
        $command = new UpdateAccountStatusCommand(TestUtils::getUserId(), UserSecurity::ACCOUNT_STATUS_DELETED);
        $registerEvent = TestUtils::getUserRegisteredEvent();
        $statusUpdated = new AccountStatusUpdatedEvent(
            TestUtils::USER_ID,
            UserSecurity::DEFAULT_ACCOUNT_STATUS,
            UserSecurity::ACCOUNT_STATUS_DELETED);

        $this->scenario
            ->given([$registerEvent])
            ->when($command)
            ->then([$statusUpdated]);
    }

    /**
     * @test
     */
    public function updating_to_the_same_status_yields_no_change()
    {
        $command = new UpdateAccountStatusCommand(TestUtils::getUserId(), UserSecurity::ACCOUNT_STATUS_DELETED);
        $event = new AccountStatusUpdatedEvent(TestUtils::getUserId(), UserSecurity::ACCOUNT_STATUS_ACTIVE, UserSecurity::ACCOUNT_STATUS_DELETED);

        $this->scenario
            ->given([$event])
            ->when($command)
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
