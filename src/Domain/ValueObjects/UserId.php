<?php

namespace Milio\User\Domain\ValueObjects;

/**
 * Makes it possible to extend this.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class UserId
{
    abstract public function __toString();

    abstract public function getUserId();
}
