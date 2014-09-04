<?php

namespace Milio\User\Domain\ValueObjects;

/**
 * String implementation.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class StringUserId extends UserId
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @param $string
     */
    public function __construct($string)
    {
        $this->userId = $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->userId;
    }
}
