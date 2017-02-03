<?php
namespace MyBarter\controllers;
use MyBarter\lib\Controller;
use MyBarter\lib\LoginForm;
use MyBarter\lib\RegistrationForm;
use MyBarter\lib\Router;
use MyBarter\lib\Session;
use MyBarter\models\User;

class UsersController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();

    }

    public function login()
    {
        Session::get('username') ? Router::redirect(PRELINK . 'users/current') : null;
        $form = new LoginForm($_POST, $this->model);
    }

    public function current()
    {
        Session::get('username') ?: Router::redirect(PRELINK . 'users/login');
        $this->data['ads'] = $this->model->getAdsByUserId(Session::get('id'));
    }

    public function messages()
    {
        Session::get('username') ?: Router::redirect(PRELINK . 'users/login');
        $this->data['messages'] = $this->model->getMessagesByUserId(Session::get('id'));
    }

    public function options()
    {
//        die(var_dump($_POST));
        Session::get('username') ?: Router::redirect(PRELINK . 'users/login');
        $this->data['user'] = $this->model->userInfo(Session::get('id'))[0];
        $this->model->changeUserInfo(Session::get('id'),$_POST,$this->data['user']);
    }

    public function confirm()
    {
        $this->model->confirm();
        Session::hasFlash() ? null : Router::redirect(PRELINK);
    }

    public function register()
    {
        $form = new RegistrationForm($_POST, $this->model);
    }

    /*public function admin_login()
    {
        if($_POST&& isset($_POST['login'])&& isset($_POST['password'])){
            $user=$this->model->getByLogin($_POST['login']);
            $hash=md5(Config::get('salt').$_POST['password']);

            if($user&& $user['is_active'] && $hash==$user['password']){

                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
            }
            Router::redirect(PRELINK.'admin/');

        }
    }*/

    public function logout()
    {
        Session::destroy();
        Router::redirect(PRELINK);
    }


    public function deleteAccount()
    {
        Session::get('username') ?: Router::redirect(PRELINK . 'users/login');
        if (!empty($_POST['delete'])) {
            $result = $this->model->deactivateAccount(Session::get('id'));
            if ($result) {
                Session::setFlash('Ваш аккаунт был удален');

            } else {
                Session::setErrorFlash('Ошибка');
            }
            Session::destroy();
            Router::redirect(PRELINK);
        }
    }
}
