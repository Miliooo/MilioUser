<?php

namespace Milio\User\Domain\Read\Presenter;

use Milio\User\Domain\Read\Model\ViewUserProfile;

/**
 * Class AbstractProfilePresenter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class AbstractProfilePresenter
{
    protected $profile;

    /**
     * @param ViewUserProfile $profile
     */
    public function __construct(ViewUserProfile $profile = null)
    {
        $this->profile = $profile;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->profile->getUserId();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return ucFirst($this->profile->getUsername());
    }

    /**
     * @return String <img string>
     */
    public function getAvatar()
    {
        return $this->getGravatar('foo@test.com');
    }


    public abstract function getStatus();

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'id' => $this->profile->getUserId(),
            'user_name' => $this->getUsername(),
            'status' => $this->getStatus()
        ];
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s     Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d     Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r     Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool   $img   True to return a complete IMG tag False for just the URL
     * @param array  $atts  Optional, additional key/value attributes to include in the IMG tag
     *
     * @return String containing either just a URL or a complete image tag
     */
    private function getGravatar($email, $s = 80, $d = 'monsterid', $r = 'g', $img = true, $atts = [])
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
