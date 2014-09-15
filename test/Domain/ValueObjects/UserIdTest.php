<?php

namespace Milio\User\Domain\ValueObjects;

use Milio\CQRS\Identifier\AggregateIdentifier;
use Milio\CQRS\Identifier\Testing\AggregateIdentifierTestCase;

class UserIdTest extends AggregateIdentifierTestCase
{
    /**
     * @return AggregateIdentifier
     */
    public function getAggregateIdentifier()
    {
        return new UserId('foo');
    }
}
