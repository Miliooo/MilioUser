<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\Testing\SerializableEventTestCase;
use Milio\User\Domain\Utils\TestUtils;

/**
 * Class UserRegisteredEventTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRegisteredEventTest extends SerializableEventTestCase
{
    /**
     * @return mixed
     */
    protected function createEvent()
    {
        return new UserDeletedEvent(TestUtils::USER_ID);
    }
}
