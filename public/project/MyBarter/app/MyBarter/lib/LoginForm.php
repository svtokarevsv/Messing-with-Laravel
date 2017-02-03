<?php
namespace MyBarter\lib;
class LoginForm extends Form
{

    /**
     * @param array $data
     */
    public function __construct(Array $data, $model)
    {
        parent::__construct($data, $model);
        $this->login();
    }

    /**
     * @return bool
     */
    public function login()
    {
        if (!empty($this->email) && !empty($this->password)) {
            $user = $this->model->getByEmail($this->email);
            $hash = new Password($this->password);
//            die($hash.'---'.$user['password']);

            if ($user && $user['is_active'] && $hash == $user['password']) {

                Session::set('username', $user['name']);
                Session::set('role', $user['id_role']);
                Session::set('id', $user['user_id']);
                if ($_POST['remember'] = 1) {
                    setcookie('sess', $user['sess'], time() + 60 * 60 * 24 * 90, '/', false, true);
                }
                Router::redirect(PRELINK . 'users/current');
            } else {
                Session::setErrorFlash('Введены неверные данные');

            }


        }
    }


}
