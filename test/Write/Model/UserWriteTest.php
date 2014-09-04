<?php

namespace test\Write\Model;

use Milio\User\Write\Model\UserWrite;
use Milio\User\ValueObjects\Password;
use Milio\User\ValueObjects\StringUserId;

/**
 * Test file for the user write model.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserWriteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_set_attributes_and_return_self()
    {
        $user = UserWrite::registerUser(
            new StringUserId('foo'),
            'name',
            'foo@bar.com',
            new Password('hashed', 'salt', '123'),
            new \DateTime('now')
        );

        $this->assertInstanceOf('Milio\User\Write\Model\UserWrite', $user);
        $this->assertAttributeEquals('name', 'username', $user);
        $this->assertAttributeEquals('hashed', 'hashedPassword', $user);
    }
}
