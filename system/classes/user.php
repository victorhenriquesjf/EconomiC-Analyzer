<?php

class user
{
    private $id_user;
    private $name_user;
    private $login;
    private $password;
    private $status;
    private $email_user;

    /**
     * user constructor.
     * @param $id_user
     * @param $name_user
     * @param $login
     * @param $password
     * @param $status
     * @param $email_user
     */
    public function __construct($id_user, $name_user, $login, $password, $status, $email_user)
    {
        $this->id_user = $id_user;
        $this->name_user = $name_user;
        $this->login = $login;
        $this->password = $password;
        $this->status = $status;
        $this->email_user = $email_user;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getNameUser()
    {
        return $this->name_user;
    }

    /**
     * @param mixed $name_user
     */
    public function setNameUser($name_user)
    {
        $this->name_user = $name_user;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
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
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getEmailUser()
    {
        return $this->email_user;
    }

    /**
     * @param mixed $email_user
     */
    public function setEmailUser($email_user)
    {
        $this->email_user = $email_user;
    }




}
