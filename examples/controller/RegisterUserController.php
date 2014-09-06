<?php

use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventHandling\TraceableEventBus;
use Broadway\EventStore\InMemoryEventStore;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\CommandHandling\CommandBusInterface;
use Milio\User\Domain\Write\Handler\RegisterUserCommandHandler;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Read\Projector\UserReadModelProjector;
use Broadway\ReadModel\InMemory\InMemoryRepository;
use Milio\User\Domain\Read\Repository\DoctrineORMRepositoryFactory;

require_once __DIR__ . '/../../bootstrap.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// the connection configuration
$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'user_cqrs',
];

$paths = [__DIR__ . "/../../src/Config/DoctrineORM/"];

$config = Setup::createXMLMetadataConfiguration($paths, true);
$entityManager = EntityManager::create($dbParams, $config);

$isDevMode = false;



//the readmodel projector
//$userReadRepository = new DoctrineORMRepository($entityManager, 'Milio\User\Domain\Read\Model\UserRead');
$repositoryFactory = new DoctrineORMRepositoryFactory($entityManager);
$userReadRepository = $repositoryFactory->create('user', 'Milio\User\Domain\Read\Model\UserRead');

$userReadModelProjector = new UserReadModelprojector($userReadRepository);


//The event store
$eventStore = new InMemoryEventStore();

//the event bus
$eventBus = new TraceableEventBus(new SimpleEventBus());
$eventBus->subscribe($userReadModelProjector);

$repository = new UserWriteEventSourcingRepository($eventStore, $eventBus);

//make command handler
$commandHandler = new RegisterUserCommandHandler($repository);

//make command bus
$commandBus= new SimpleCommandBus();
$commandBus->subscribe($commandHandler);

//doctrine




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
