<?php
namespace MyBarter\lib;
use MyBarter\models\User;

abstract class Session
{
    protected static $flash_message;

    public static function setFlash($message)
    {
        self::$flash_message = " <div class='alert alert-info margin-top15' role='alert'>$message</div>";
    }
    public static function setErrorFlash($message)
    {
        self::$flash_message = " <div class='alert alert-warning margin-top15' role='alert'>$message</div>";
    }

    public static function hasFlash()
    {
        return !is_null(self::$flash_message);

    }

    public static function flash()
    {
        echo self::$flash_message;
        self::$flash_message = null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return null;
    }

    public static function delete($key)
    {
        if(isset($_SESSION[$key])){
            unset ($_SESSION[$key]);
        }
    }
    public static function loginByCookie()
    {
        if(empty(Session::get('гыу')) AND empty($_SESSION['role']) AND isset($_COOKIE['sess'])) {
            $user=User::getByCookie($_COOKIE['sess']);
            self::set('username', $user['name']);
            self::set('role', $user['id_role']);
        }
    }
    public static function destroy()
    {
        session_destroy();
        setcookie('sess', "", 1);

    }
}
