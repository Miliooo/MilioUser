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
     * @param UserWriteEventSourcingRepository $repository
     */
    public function __construct(UserWriteEventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RegisterUserCommand $command
     */
    public function handleRegisterUserCommand(RegisterUserCommand $command)
    {
        $aggregate =
            UserWrite::registerUser(
            $command->userId,
            $command->username,
            $command->email,
            $command->password,
            $command->dateRegistered
        );

        $this->repository->add($aggregate);
    }
}
