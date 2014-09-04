<?php

namespace Milio\User\Domain\Write\Handler;

use Broadway\CommandHandling\CommandHandler;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\User\Domain\Write\Model\UserWriteRepository;
use Milio\User\Domain\Write\Model\UserWrite;

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
     * @param \Milio\User\Domain\Write\Command\RegisterUserCommand $command
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
