<?php

namespace Milio\User\ValueObjects;

/**
 * Makes it possible to extend this.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class UserId
{
    abstract public function __toString();
}
