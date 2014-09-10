<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\SerializableInterface;
use Milio\User\Domain\ValueObjects\UserId;

/**
 * Class UsernameChangedEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UsernameChangedEvent implements SerializableInterface
{
    private $userId;
    private $previousUsername;
    private $updatedUsername;

    /**
     * @param UserId $userId
     * @param string $previousUsername
     * @param string $updatedUsername
     */
    public function __construct(UserId $userId, $previousUsername, $updatedUsername)
    {
        $this->userId = $userId;
        $this->previousUsername = $previousUsername;
        $this->updatedUsername = $updatedUsername;
    }

    /**
     * @return string String representation of the updated username.
     */
    public function getUpdatedUsername()
    {
        return $this->updatedUsername;
    }

    /**
     * @return string String representation of the previous username.
     */
    public function getPreviousUsername()
    {
        return $this->previousUsername;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @param array $data
     *
     * @return UsernameChangedEvent
     */
    public static function deserialize(array $data)
    {
        return new self($data['user_id'], $data['previous_username'], $data['updated_username']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id' => $this->userId,
            'previous_username' => $this->previousUsername,
            'updated_username' => $this->updatedUsername
        ];
    }
}
