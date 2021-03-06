<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\Testing\SerializableEventTestCase;
use Milio\User\Domain\Utils\TestUtils;
use Milio\User\Domain\Write\Model\UserSecurity;
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
        return new UserRegisteredEvent(
            '1',
            'user_foo',
            'user_foo@foo.bar',
            'secretpass',
            'my_hash',
            new \DateTime(TestUtils::DATE_TIME),
            ['ROLE_USER'],
            UserSecurity::ACCOUNT_STATUS_DELETED
        );
    }
}
