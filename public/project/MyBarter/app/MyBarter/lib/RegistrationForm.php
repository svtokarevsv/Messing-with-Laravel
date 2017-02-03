<?php
namespace MyBarter\lib;

class RegistrationForm extends Form
{
    protected $passwordConfirm;


    /**
     * @param array $data
     */
    function __construct(Array $data, $model)
    {
        parent::__construct($data, $model);
        $this->passwordConfirm = isset($data['passwordConfirm']) ? $data['passwordConfirm'] : null;
        $_POST?$this->register():null;
    }

    public function register()
    {
        if ($this->validate()) {
            $email = $this->model->getDb()->escape($this->email);
            $username = $this->model->getDb()->escape($this->username);
            $password = new Password($this->model->getDb()->escape($this->password));

            $res = $this->model->getByEmail($this->email);
            if ($res) {
                Session::setErrorFlash("Такой имейл уже зарегистрирован");
            } else {
                $this->model->register($email,$username,$password);

                Session::set('message','Благодарим Вас за регистрацию.<br/> На Ваш имейл было отправлено письмо для активации Вашего аккаунта.<br/> Пройдите по ссылке внутри письма, чтобы активировать аккаунт');
                Router::redirect(PRELINK."users/confirm");
            }

        } else {
            $this->passwordsMatch() ? Session::setErrorFlash('Заполнены не все поля') : Session::setErrorFlash('Введенные пароли не совпадают');

        }
    }

    public function validate()
    {
        return !empty($this->email) && !empty($this->username) && !empty($this->password) && !empty($this->passwordConfirm) && $this->passwordsMatch();
    }

    public function passwordsMatch()
    {
        return $this->password == $this->passwordConfirm;
    }
}
