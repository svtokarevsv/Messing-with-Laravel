<?php
namespace MyBarter\models;
use MyBarter\lib\App;
use MyBarter\lib\Mail;
use MyBarter\lib\Model;
use MyBarter\lib\Password;
use MyBarter\lib\Session;

class User extends Model
{
    public function getByEmail($email)
    {
        $email = $this->db->escape($email);
        $sql = "select * from users where email = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public static function getByCookie($sess)
    {

        $sess = App::$db->escape($sess);
        $sql = "select * from users where sess = '{$sess}' LIMIT 1";
        $result = App::$db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function getAdsByUserId($id)
    {
        $sql = "select * from ads where id_user = '{$id}'";
        return $this->db->query($sql);
        /*if (isset($result[0])) {
            return $result[0];
        }
        return false;*/
    }
    public function getMessagesByUserId($id)
    {
        $sql = "select m.id as mess_id,m.from_id,m.to_id,m.message,m.ad_id,m.is_active,m.date,u1.name as from_name,u2.name as to_name,a.title,a.text
                from user_messages m JOIN ads a
                ON m.ad_id=a.id
                JOIN users u1 ON m.from_id=u1.user_id
                JOIN users u2 ON m.to_id=u2.user_id
                where m.to_id = {$id} OR m.from_id={$id}";
        return $this->db->query($sql);
    }

    public function register($email, $username, $password)
    {
        $sess = md5($email . microtime());
        $this->db->query("INSERT INTO users (email, name, password,sess) VALUES ({$email},{$username},{$password},{$sess})");
        $mail = new Mail("sit_tis@mail.ru"); // Создаём экземпляр класса
        $mail->setFromName("Администратор сайта"); // Устанавливаем имя в обратном адресе
        if ($mail->send("$email", "Регистрация на MyBarter.UA", "На ваши почтовый ящик была проведена регистрация на MyBarter.UA . <br />Чтобы завершить регистрацию, пройдите по ссылке: http://{$_SERVER['SERVER_NAME']}".PRELINK."users/confirm?confirm_key={$sess}<br /><b>Если это были не Вы, просто проигнорируйте это письмо. Приятных Вам приобретений!<b>")) echo "Письмо отправлено";
        else echo "Письмо не отправлено";

    }

    public function confirm()
    {
        if (!empty($_GET['confirm_key'])) {
            $sql = "UPDATE users SET
                  is_active=1 WHERE sess={$this->db->escape($_GET['confirm_key'])} LIMIT 1";
//            die($sql);
            $result = $this->db->query($sql);

            if ($this->db->getConnection()->affected_rows == 1) {
                Session::setFlash("Ваш аккаунт успешно активирован.<br/> Вы теперь можете авторизоваться.<br/>Успешных Вам приобретений!");
            } else {
                Session::setErrorFlash("Неверный код авторизации");
//                Session::set('message', "Неверный код авторизации");
            }
        }

//        if (isset($result)) {
//            return true;
//        }
//        return false;
    }

    public function changeUserInfo($user_id, array $array, $user_info)
    {
        $id = (int)$user_id;
        if (isset($array['change_contacts'])){
            $sql = "UPDATE users SET
            name={$array['name']}, phone={$array['phone']} WHERE user_id={$user_id} LIMIT 1";
            Session::set('message','Персональные данные изменены');
            Session::set('username',$array['name']);
        }
        if (isset($array['change_email'])){
            $sql = "UPDATE users SET
              email={$array['email']} WHERE user_id={$user_id} LIMIT 1";
            Session::set('message','Email изменен');
        }
        if (isset($array['change_pass'])) {
            $oldPass = new Password($array['oldpass']);
            $newPass = new Password($array['newpass']);
            if ($oldPass == $user_info['password']) {
                $sql = "UPDATE users SET
              password={$newPass} WHERE user_id={$user_id} LIMIT 1";
                Session::set('message','Пароль успешно изменен');
            } else {
                Session::set('message', 'Введен неправильный пароль');
            }
        }

        if(!empty($sql))
        $this->db->query($sql);

    }

    public function deactivateAccount($user_id)
    {
        $user_id = (int)$user_id;
        $sql = "UPDATE ads SET
              is_active=0 WHERE id_user={$user_id}";
        $this->db->query($sql);
        $sql = "UPDATE users SET
              is_active=0 WHERE user_id={$user_id} LIMIT 1";

        return $this->db->query($sql);
    }
}

