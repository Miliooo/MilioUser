<?php

namespace Milio\User\Write\Model;

use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;

/**
 * Class UserWriteRepository
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserWriteRepository extends EventSourcingRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface   $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, 'Milio\User\Write\Model\UserWrite');
    }
}
