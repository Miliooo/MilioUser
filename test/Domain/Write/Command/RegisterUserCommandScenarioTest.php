<?php

namespace Milio\User\Domain\Write\Command;

use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;
use Broadway\CommandHandling\CommandHandlerInterface;
use Milio\User\Domain\Write\Handler\SecurityUserCommandHandler;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;

/**
 * Class RegisterUserCommandFunctionalTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserCommandScenarioTestCase extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function it_registers_new_users()
    {
        $command = TestUtils::getRegisterUserCommand();
        $event = TestUtils::getUserRegisteredEvent();

        $this->scenario
            ->given([])
            ->when($command)
            ->then([$event]);
    }

    /**
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
