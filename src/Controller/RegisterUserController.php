<?php

namespace Milio\User\Controller;

use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventHandling\TraceableEventBus;
use Broadway\EventStore\InMemoryEventStore;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\CommandHandling\CommandBusInterface;
use Milio\User\Write\Handler\RegisterUserCommandHandler;
use Milio\User\Write\Listener\VarDumpListener;
use Milio\User\Write\Model\UserWriteRepository;
use Milio\User\Utils\TestUtils;

require_once __DIR__ . '/../../bootstrap.php';

//make repository
$eventStore = new InMemoryEventStore();
$eventBus = new TraceableEventBus(new SimpleEventBus());
$eventBus->subscribe(new VarDumpListener());
$repository = new UserWriteRepository($eventStore, $eventBus);

//make command handler
$commandHandler = new RegisterUserCommandHandler($repository);

//make command bus
$commandBus= new SimpleCommandBus();
$commandBus->subscribe($commandHandler);


new CreateUserController($commandBus);

/**
 * Class CreateUserController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateUserController
{
    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $command = TestUtils::getRegisterUserCommand();
        $commandBus->dispatch($command);
    }
}
