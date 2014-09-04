<?php

namespace Milio\User\Write\Command;

use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;
use Broadway\CommandHandling\CommandHandlerInterface;
use Milio\User\Write\Handler\RegisterUserCommandHandler;
use Milio\User\Utils\TestUtils;
use Milio\User\Write\Event\UserRegisteredEvent;
use Milio\User\Write\Model\UserWriteRepository;

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
    public function it_can_register_new_users()
    {
        $command = TestUtils::getRegisterUserCommand();

        $this->scenario
            ->given([])
            ->when($command)
            ->then([new UserRegisteredEvent(
                TestUtils::getUserId(),
                TestUtils::getUsername(),
                TestUtils::getEmail(),
                TestUtils::getPasswordVO(),
                TestUtils::getDateTime()
            )]);
    }

    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface   $eventBus
     *
     * @return CommandHandlerInterface
     */
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        $repository = new UserWriteRepository($eventStore, $eventBus);

        return new RegisterUserCommandHandler($repository);
    }
}
