<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\SerializableInterface;

/**
 * Class UserDeletedEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserDeletedEvent implements SerializableInterface
{
    public $userId;

    /**
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param array $data
     *
     * @return UserDeletedEvent
     */
    public static function deserialize(array $data)
    {
        return new self($data['user_id']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['user_id' => $this->userId];
    }
}
