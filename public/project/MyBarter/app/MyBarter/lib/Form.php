<?php
namespace MyBarter\lib;
class Form
{
    protected $email;
    protected $username;
    protected $password;
    protected $model;


    /**
     * @param array $data
     */
    function __construct(Array $data,$model)
    {
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->username = isset($data['name']) ? $data['name'] : null;
        $this->password = isset($data['password']) ? $data['password'] : null;
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

}
