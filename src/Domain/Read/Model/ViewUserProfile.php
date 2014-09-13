<?php

namespace Milio\User\Domain\Read\Model;

use Broadway\ReadModel\ReadModelInterface;

/**
 * This view is used for displaying user data.
 * It should not contain sensitive data since we could show this user information by JSON responses.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ViewUserProfile implements ReadModelInterface
{
    /**
     * @var integer //used by relational databases, we should never work with it.
     */
    public $id;

    /**
     * @var string The uuid
     */
    public $userId;

    /**
     * @var string the username.
     */
    public $username;

    /**
     * @var boolean We should filter our results based on this.
     */
    public $isDeleted;

    /**
     * @var string
     */
    public $accountStatus;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->userId;
    }

    /**
     * @return boolean
     */
    public function getIsDeleted()
    {
        return (bool) $this->isDeleted;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
}
