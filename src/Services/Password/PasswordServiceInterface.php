<?php

namespace Milio\User\Services\Password;

/**
 * Interface PasswordCreatorInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface PasswordServiceInterface
{
    /**
     * @param $raw
     * @param $salt
     *
     * @return string The encoded password
     */
    public function getEncodedPassword($raw, $salt);

    /**
     * @param $encoded
     * @param $raw
     * @param $salt
     *
     * @return boolean
     */
    public function isPasswordValid($encoded, $raw, $salt);
}
