<?php

namespace Milio\User\Domain\Write\Command;
use Milio\CQRS\Command\CommandInterface;

/**
 * Class AbstractUserCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AbstractUserCommand implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'user';
    }
}
