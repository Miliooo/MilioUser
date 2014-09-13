<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\Testing\SerializableEventTestCase;

/**
 * Class UserRegisteredEventTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AccountStatusUpdatedEventTest extends SerializableEventTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createEvent()
    {
        return new AccountStatusUpdatedEvent('5', 'previous', 'updatedd');
    }
}
