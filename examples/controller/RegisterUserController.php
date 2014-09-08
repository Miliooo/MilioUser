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
use Milio\User\Domain\Read\Repository\DoctrineORMRepositoryFactory;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\EventStore\DBALEventStore;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

require_once __DIR__ . '/../../bootstrap.php';

//validation

$mappingDir = __DIR__ . '/../../src/Config/Validation/validation.xml';


$validator = Validation::createValidatorBuilder()
    ->addXmlMapping($mappingDir)
    ->setApiVersion(Validation::API_VERSION_2_5)
    ->getValidator();


//Dbal
$DbalConfig = new \Doctrine\DBAL\Configuration();
$connectionParams = [
    'dbname' => 'user_cqrs',
    'user' => 'root',
    'password' => 'root',
    'driver' => 'pdo_mysql',
    ];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $DbalConfig);


$dbalEventStore = new DBALEventStore($conn, new SimpleInterfaceSerializer(), new SimpleInterfaceSerializer(), 'milia_user_eventstore');
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

$repository = new UserWriteEventSourcingRepository($dbalEventStore, $eventBus, 'Milio\User\Domain\Write\Model\UserWrite');

//make command handler
$commandHandler = new RegisterUserCommandHandler($repository);

//make command bus
$commandBus= new SimpleCommandBus();
$commandBus->subscribe($commandHandler);

//doctrine




$controller = new CreateUserController($commandBus, $validator);
$controller->updateAction();

/**
 * Class CreateUserController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateUserController
{
    /**
     * @var Broadway\CommandHandling\CommandBusInterface
     */
    private $commandBus;

    /**
     * @var Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * @param CommandBusInterface $commandBus
     * @param ValidatorInterface  $validator
     */
    public function __construct(CommandBusInterface $commandBus, \Symfony\Component\Validator\Validator\ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    /**
     *
     */
    public function updateAction()
    {
        //get the data from the form
        //send it to the bus
        $command = TestUtils::getRegisterUserCommand();

        //validate the command object
        $violationList = $this->validator->validate($command);
        if($violationList->count() !== 0) {
            echo 'command not send, invalid command';
            echo (string) $violationList;
            return;
        }

        $this->commandBus->dispatch($command);

        //when asynchronous need to redirect to other page and do some polling or pray for the best

        echo 'registering '.$command->username."\n";
        //when synchronous wait for response and decide on that
        echo 'response'."\n\n";
    }
}
