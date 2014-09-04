<?php

namespace Milio\User\Write\Command;

use Milio\User\Utils\TestUtils;

/**
 * Test file for the RegisterUserCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider attributeDataProvider
     */
    public function it_should_set_attributes($value, $attribute, $msg)
    {
        $command = new RegisterUserCommand(
            TestUtils::getUserId(),
            TestUtils::getUsername(),
            TestUtils::getEmail(),
            TestUtils::getPasswordVO(),
            TestUtils::getDateTime()
        );

        $this->assertAttributeEquals($value, $attribute, $command, $msg);
    }

    /**
     * @return array
     */
    public function attributeDataProvider()
    {
        return [
            [TestUtils::getUserId(), 'userId', 'userI', 'set userId'],
            [TestUtils::getUsername(), 'username', 'set username'],
            [TestUtils::getEmail(), 'email', 'set email'],
            [TestUtils::getPasswordVO(), 'password', 'set password'],
            [TestUtils::getDateTime(), 'dateRegistered', 'set dateRegistered']
        ];
    }
}
