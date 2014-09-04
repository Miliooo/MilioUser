<?php

namespace Milio\User\Write\Handler;

use Broadway\CommandHandling\CommandHandler;
use Milio\User\Write\Command\RegisterUserCommand;
use Milio\User\Write\Model\UserWriteRepository;
use Milio\User\Write\Model\UserWrite;

/**
 * Class RegisterUserCommandHandler
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserCommandHandler extends CommandHandler
{
    /**
     * @var UserWriteRepository
     */
    private $repository;

    /**
     * @param UserWriteRepository $repository
     */
    public function __construct(UserWriteRepository $repository)
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
