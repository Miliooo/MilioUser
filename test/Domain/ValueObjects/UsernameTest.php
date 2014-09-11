<?php

namespace Milio\User\Domain\ValueObjects;

/**
 * Class UsernameTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UsernameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider noStringProvider
     */
    public function it_should_be_a_string($argument)
    {
        $this->setExpectedException('Milio\User\Domain\ValueObjects\Exceptions\UsernameException');
        $this->getUsernameObject($argument);
    }

    /**
     * @test
     */
    public function it_should_be_trimmed()
    {
        $username = $this->getUsernameObject('   foo');
        $this->assertEquals('foo', $username->getUsername());
    }

    /**
     * @test
     *
     * @dataProvider minLengthProvider
     */
    public function it_should_have_at_least_two_characters($username)
    {
        $this->setExpectedException('Milio\User\Domain\ValueObjects\Exceptions\UsernameException');
        $this->getUsernameObject($username);
    }

    /**
     * @test
     */
    public function it_should_have_maximum_25_characters()
    {
        $this->setExpectedException('Milio\User\Domain\ValueObjects\Exceptions\UsernameException');
        $this->getUsernameObject('this_is_a_very_long_username_maybe_a_bit_too_long');
    }

    /**
     * Helper function since this class is abstract.
     *
     * @param string $constructorArgument The constructor argument.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Username
     */
    private function getUsernameObject($constructorArgument)
    {
        return $this->getMockForAbstractClass('Milio\User\Domain\ValueObjects\Username', [$constructorArgument]);
    }

    /**
     * @return array
     */
    public function noStringProvider()
    {
        return [
            [null],
            [false],
            [1],
            [new \stdClass],
        ];
    }

    /**
     * @return array
     */
    public function minLengthProvider()
    {
        return [
            ['e'],
            ['&'],
            ['@'],
        ];
    }
}
