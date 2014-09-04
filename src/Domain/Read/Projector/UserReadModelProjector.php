<?php

namespace Milio\User\Domain\Read\Projector;

use Broadway\ReadModel\Projector;
use Broadway\Domain\DomainMessageInterface;

/**
 * Class UserReadModelProjector
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserReadModelProjector extends Projector
{
    /**
     * @param                        $event
     * @param DomainMessageInterface $domainMessage
     */
    public function applyUserRegisteredEvent($event, DomainMessageInterface $domainMessage)
    {
        echo 'applying user registered event';
    }
}
