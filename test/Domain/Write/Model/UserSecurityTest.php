<?php

namespace Milio\User\Domain\Write\Model;

use Milio\User\Domain\ValueObjects\BasicUsername;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\ValueObjects\StringUserId;

/**
 * Test file for the user write model.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserSecurityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_set_attributes_and_return_self()
    {
        $user = UserSecurity::registerUser(
            new StringUserId('foo'),
            new BasicUsername('name'),
            'foo@bar.com',
            new Password('hashed', 'salt', '123'),
            new \DateTime('now')
        );

        $this->assertInstanceOf('Milio\User\Domain\Write\Model\UserSecurity', $user);
        $this->assertAttributeEquals('name', 'username', $user);
        $this->assertAttributeEquals('hashed', 'password', $user);
    }
}
