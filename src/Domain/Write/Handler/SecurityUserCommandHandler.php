<?php

namespace Milio\User\Domain\Write\Handler;

use Broadway\CommandHandling\CommandHandler;
use Milio\User\Domain\Write\Command\ChangeUsernameCommand;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Model\UserSecurity;

/**
 * Class SecurityUserCommandHandler
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class SecurityUserCommandHandler extends CommandHandler
{
    /**
     * @var UserWriteEventSourcingRepository
     */
    private $repository;

    /**
     * @var UserSecurity
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

    /**
     * @param ChangeUsernameCommand $command
     */
    public function handleChangeUsernameCommand(ChangeUsernameCommand $command)
    {
        /** @var UserSecurity $aggregate */
        $aggregate = $this->repository->load($command->userId->getUserId());
        $aggregate->changeUsername($command->username);
        $this->repository->add($aggregate);
    }
}
