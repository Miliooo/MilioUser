<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\Testing\SerializableEventTestCase;
use Milio\User\Domain\Utils\TestUtils;

/**
 * Class UsernameChangedEventTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UsernameChangedEventTest extends SerializableEventTestCase
{
    /**
     * @return mixed
     */
    protected function createEvent()
    {
        return new UsernameChangedEvent(TestUtils::getUserId(), 'previous', 'updated');
    }
}
