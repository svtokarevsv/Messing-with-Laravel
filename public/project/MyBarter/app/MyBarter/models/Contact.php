<?php
namespace MyBarter\models;
use MyBarter\lib\Mail;
use MyBarter\lib\Model;
use MyBarter\lib\Session;

class Contact extends Model
{
    public function save($data)
    {
        if($this->validate($data)) {

            $name = $this->db->escape($data['name']);
            $theme = $this->db->escape($data['theme']);
            $email = $this->db->escape($data['email']);
            $message = $this->db->escape(nl2br($data['message']));

            //Add new record
                $sql = "
                insert into contact_messages
                  set name = {$name},
                      email = {$email},
                      theme = {$theme},
                      message = {$message} ";
            $mail = new Mail("sit_tis@mail.ru"); // Создаём экземпляр класса
            $mail->setFromName("MyBarter.UA - Контактная форма"); // Устанавливаем имя в обратном адресе
            $mail->send("svtokarevsv@gmail.com", "$theme", "Сообщение от $email <br/>Имя отправителя: $name <br/>Сообщение:<br/>$message" );

            return $this->db->query($sql);

        }else{
            Session::setErrorFlash('Неверно введены данные');
            return false;
        }
    }

    public function validate($data)
    {
        if(empty($data['name'])||empty($data['email'])||empty($data['theme'])||empty($data['message']))
            return false;else return true;
    }
    public function getList()
    {
        $sql = "select * from messages where 1";
        return $this->db->query($sql);
    }
}
