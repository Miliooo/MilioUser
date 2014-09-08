<?php

namespace Milio\User\Domain\Write\Model;

use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;

/**
 * Class UserWriteRepository
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserWriteEventSourcingRepository extends EventSourcingRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface   $eventBus
     * @param string              $aggregateClass
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus, $aggregateClass)
    {
        parent::__construct($eventStore, $eventBus, $aggregateClass);
    }
}
