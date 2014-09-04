<?php

use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventHandling\TraceableEventBus;
use Broadway\EventStore\InMemoryEventStore;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\CommandHandling\CommandBusInterface;
use Milio\User\Domain\Write\Handler\RegisterUserCommandHandler;
use Milio\User\Domain\Write\Model\UserWriteRepository;
use Milio\User\Domain\Utils\TestUtils;

require_once __DIR__ . '/../../bootstrap.php';

//make repository
$eventStore = new InMemoryEventStore();
$eventBus = new TraceableEventBus(new SimpleEventBus());

$repository = new UserWriteRepository($eventStore, $eventBus);

//make command handler
$commandHandler = new RegisterUserCommandHandler($repository);

//make command bus
$commandBus= new SimpleCommandBus();
$commandBus->subscribe($commandHandler);

$controller = new CreateUserController($commandBus);
$controller->updateAction();

/**
 * Class CreateUserController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateUserController
{
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     *
     */
    public function updateAction()
    {
        //get the data from the form

        //validate the command object

        //send it to the bus
        $command = TestUtils::getRegisterUserCommand();
        $this->commandBus->dispatch($command);

        //when asynchronous need to redirect to other page and do some polling or pray for the best

        echo 'registering '.$command->username."\n";
        //when synchronous wait for response and decide on that
        echo 'response'."\n\n";
    }
}
