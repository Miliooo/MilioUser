<?php

namespace Milio\User\Domain\Read\Presenter;

/**
 * Interface UserProfilePresenterInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserProfilePresenterInterface
{
    /**
     * @return array
     */
    public function getData();

    /**
     * @return string
     */
    public function getName();
}
