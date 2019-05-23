<?php
/********************************
 * Created by ktroufleau.
 * Date: 20/05/2019
 * Time: 21:25
 ********************************/


namespace Anaxago\CoreBundle\Entity;

/**
 * Class Credentials
 * @package Anaxago\CoreBundle\Entity
 */
class Credentials
{
    protected $login;

    protected $password;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}