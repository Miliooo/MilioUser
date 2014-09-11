<?php

namespace Milio\User\Domain\ValueObjects;

use Rhumsaa\Uuid\Uuid;

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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->userId;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @param string $value
     *
     * @return static
     */
    public static function generate($value = '')
    {
        if (empty($value)) {
            return new static(Uuid::uuid4()->toString());
        }

        return new static($value);
    }
}
