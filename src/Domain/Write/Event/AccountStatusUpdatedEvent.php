<?php

namespace Milio\User\Domain\Write\Event;

use Broadway\Serializer\SerializableInterface;

/**
 * Class AccountStatusUpdatedEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AccountStatusUpdatedEvent implements SerializableInterface
{
    /**
     * @var string
     */
    public $userId;

    /**
     * @var string
     */
    public $previous;

    /**
     * @var string
     */
    public $updated;

    /**
     * Constructor.
     *
     * @param string $userId
     * @param string $previous
     * @param string $updated
     */
    public function __construct($userId, $previous, $updated)
    {
        $this->userId = $userId;
        $this->previous = $previous;
        $this->updated = $updated;

    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        return new self($data['user_id'], $data['previous'], $data['updated']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return [
            'user_id' => $this->userId,
            'previous' => $this->previous,
            'updated' => $this->updated
        ];
    }
}
