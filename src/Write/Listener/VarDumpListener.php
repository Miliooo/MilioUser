<?php

namespace Milio\User\Write\Listener;

use Broadway\Domain\DomainMessageInterface;
use Broadway\EventHandling\EventListenerInterface;

/**
 * Class VarDumpListener, only for testing.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class VarDumpListener implements EventListenerInterface
{
    /**
     * @param DomainMessageInterface $domainMessage
     */
    public function handle(DomainMessageInterface $domainMessage)
    {
        echo "[VARDUMP_LISTENER]\n";
        var_dump($domainMessage);
    }
}
