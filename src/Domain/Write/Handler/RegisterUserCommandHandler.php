<?php

namespace Milio\User\Domain\Write\Handler;

use Broadway\CommandHandling\CommandHandler;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Model\UserWrite;

/**
 * Class RegisterUserCommandHandler
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserCommandHandler extends CommandHandler
{
    /**
     * @var UserWriteEventSourcingRepository
     */
    private $repository;

    /**
     * @var UserWrite
     */
    private $className;

    /**
     * @param UserWriteEventSourcingRepository $repository
     * @param string                           $className
     */
    public function __construct(UserWriteEventSourcingRepository $repository, $className)
    {
        $this->repository = $repository;
        $this->className = $className;
    }

    /**
     * @param RegisterUserCommand $command
     */
    public function handleRegisterUserCommand(RegisterUserCommand $command)
    {
        $userWrite = $this->className;
        $aggregate =
            $userWrite::registerUser(
            $command->userId,
            $command->username,
            $command->email,
            $command->password,
            $command->dateRegistered
        );

        $this->repository->add($aggregate);
    }
}
