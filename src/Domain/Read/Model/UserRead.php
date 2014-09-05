<?php

namespace Milio\User\Domain\Read\Model;

use Broadway\ReadModel\ReadModelInterface;

/**
 * User Read model
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRead implements ReadModelInterface
{
    public $id;

    public $name;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
