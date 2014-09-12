<?php

namespace Milio\User\Domain\Write\Handler;

use Broadway\CommandHandling\CommandHandler;
use Milio\User\Domain\Write\Command\ChangeUsernameCommand;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\User\Domain\Write\Command\DeleteUserCommand;
use Milio\User\Domain\Write\Model\UserWriteEventSourcingRepository;
use Milio\User\Domain\Write\Model\UserSecurity;
use Milio\User\Domain\ValueObjects\UserId;


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
    protected $repository;

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
        $aggregate = $this->loadAggregate($command->userId);
        $aggregate->changeUsername($command->username);
        $this->repository->add($aggregate);
    }

    /**
     * @param DeleteUserCommand $command
     */
    public function handleDeleteUserCommand(DeleteUserCommand $command)
    {
        $aggregate = $this->loadAggregate($command->userId);
        $aggregate->deleteUser($command->userId);
        $this->repository->add($aggregate);
    }

    /**
     * @param UserId $userId
     *
     * @return UserSecurity
     */
    protected function loadAggregate(UserId $userId)
    {
        return $this->repository->load((string) $userId);
    }
}
