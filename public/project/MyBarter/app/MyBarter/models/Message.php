<?php
namespace MyBarter\models;
use MyBarter\lib\Mail;
use MyBarter\lib\Model;

class Message extends Model
{

    public function save_message($to_id, $from_id,$message, $ad_id,$ad_title)
    {
        $this->db->query("INSERT INTO user_messages (to_id,from_id, message,ad_id) VALUES ({$to_id},{$from_id},{$message},{$ad_id})");
        $mail = new Mail("sit_tis@mail.ru"); // Создаём экземпляр класса
        $mail->setFromName("Сообщения | MyBarter.UA"); // Устанавливаем имя в обратном адресе
        $from_user=$this->userInfo($from_id)[0];
        $to_user=$this->userInfo($to_id)[0];
        $mail->send("{$to_user['email']}", "Новое сообщение - $ad_title", "<h2>Вам пришло новое сообщение на MyBarter.UA по объявлению '{$ad_title}' </h2> <h4>От {$from_user['name']} - {$from_user['email']}. </h4><p>$message</p> <br/> <strong>Посмотреть все Ваши сообщения:</strong> <br/><a href='http://{$_SERVER['SERVER_NAME']}".PRELINK."users/messages' >Сообщения на MyBarter.UA</a>");
        return $this->db->getConnection()->affected_rows;

    }

    public function getUserMessageById($id)
    {
        $sql = "select m.id as mess_id,m.from_id,m.to_id,m.message,m.ad_id,m.is_active,m.date,u1.name as from_name,u2.name as to_name,a.title,a.text
                from user_messages m JOIN ads a
                ON m.ad_id=a.id
                JOIN users u1 ON m.from_id=u1.user_id
                JOIN users u2 ON m.to_id=u2.user_id
                where m.id = {$id} LIMIT 1";
        return $this->db->query($sql);
    }

}
