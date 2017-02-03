<?php
namespace MyBarter\lib;
class Password
{
    private $password;
    private $hashedPassword;
    private $salt;

    function __construct($password, $saltText = null)
    {
        $this->password = $password;
        $this->salt = is_null($saltText) ? Config::get('salt') : $saltText ;
        $this->hashedPassword = md5($this->salt . $this->password);
    }

    public function __toString()
    {
        return $this->hashedPassword;
    }
}
