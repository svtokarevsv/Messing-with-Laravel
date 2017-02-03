<?php
namespace MyBarter\models;

use MyBarter\lib\Config;
use MyBarter\lib\Mail;
use MyBarter\lib\Model;
use MyBarter\lib\Pagination;
use MyBarter\lib\Router;
use MyBarter\lib\Session;

/**
 * Class Category
 * @package MyBarter\models
 */
class Category extends Model
{
    public function getCategories()
    {
        $sql = "select * from categories";

        return $this->db->prepared_query($sql);
    }

    public function getRegions()
    {
        $sql = "select * from regions";

        return $this->db->prepared_query($sql);
    }

    public function getRegion($id)
    {
        $data['id']=$id;
        $sql = "select region from regions where id= :id";

        return $this->db->prepared_query($sql,$data);
    }

    public function allAds()
    {
        $sql = "select * from ads ORDER BY id DESC ";

        return $this->db->prepared_query($sql);
    }


    public function new_ad($title, $text, $id_user, $id_categories, $region, $price, $img = false, $img_other = false, $img_other2 = false)
    {
        $data=compact('title','text','id_user','id_categories','price','img','img_other','img_other2');
        $data['region']=$this->getRegion($region)[0]['region'];
        $sql = "INSERT INTO ads (title, text,id_user,id_categories,region,price,img,img_other,img_other2) VALUES (:title, :text,:id_user,:id_categories,:region,:price,:img,:img_other,:img_other2)";
//        die($sql);
        $result = $this->db->prepared_exec($sql,$data);
        if ($result>0) {
            Session::setFlash("Ваше объявление успешно добавлено.<br/> Скоро оно появится на нашем сайте");
        } else {
            Session::setErrorFlash("Что-то пошло не так, попробуйте еще раз");
        }
    }


    public function update_ad($id, $title, $text, $id_categories, $region, $price, $img = false, $img_other = false, $img_other2 = false)
    {
        $sql = "UPDATE ads SET title='{$title}',
                               text='{$text}',
                               id_categories={$id_categories},
                               region='{$this->getRegion($region)[0]['region']}',
                               price={$price},
                               img='{$img}',
                               img_other='{$img_other}',
                               img_other2='{$img_other2}'
                               WHERE id={$id}";
//        die($sql);

        $result = $this->db->exec($sql);
//        if ($this->db->getConnection()->affected_rows == 1) {
            Router::redirect(PRELINK . 'users/current');
//        } else {
//            Session::setErrorFlash("Что-то пошло не так, попробуйте снова");
//        }
    }

    public function deactivateAd($id, $user)
    {
        $id = (int)$id;
        $sql = "UPDATE ads SET
              is_active=0 where id={$id} AND id_user=$user";
        return $this->db->query($sql);
    }


    public function getAds($adId = false)
    {
        $sort = ' a.date DESC';
        $sql = "SELECT a.`id`, a.`title`, a.`date`, a.`id_categories`, a.`region`, a.`img`, a.`is_active`, a.`price`,c.name,cc.name as parent
                    FROM `ads` a JOIN categories c
                    ON a.id_categories=c.id
                    JOIN categories cc ON cc.id=c.parent_id WHERE a.`is_active`=1";
        if (!empty($_GET['search'])) {
            $search = $this->db->escape("%" . $_GET['search'] . "%");
            $sql .= " and (a.title LIKE " . $search;
            if (!empty($_GET['description_search']) AND $_GET['description_search'] == "on") {
                $sql .= " OR a.text LIKE " . $search . ')';
            } else $sql .= ')';
        }
        if (!empty($_GET['region'])) {
            $region = $this->db->escape($_GET['region']);
            $sql .= " and a.region like {$region}";
        }
        if (!empty($_GET['photo_search']) AND $_GET['photo_search'] == "on") {
            $sql .= ' and a.img NOT in ("")';
        }
        if (!empty($_GET['category'])) {
            $category = $this->db->escape($_GET['category']);
            if (in_array(mb_strtolower($_GET['category']), array("транспорт", "электроника", "одежда", "недвижимость"))) {
                $sql .= " and cc.name like {$category}";
            } else {
                $sql .= " and c.name like {$category}";
            }
        }
        if (!empty($_GET['price_from']) || !empty($_GET['price_from'])) {
            $from = 0;
            $to = 10000000000;
            if (!empty($_GET['price_from'])) {
                $from = $this->db->escape(floatval($_GET['price_from']));
            }
            if (!empty($_GET['price_to'])) {
                $to = $this->db->escape(floatval($_GET['price_to']));
            }
            $sql .= " and a.price BETWEEN {$from} AND {$to}";
        }
        if (!empty($_GET['sort'])) {
            if ($sort = $this->db->escape($_GET['sort']) == 'new') {
                $sort = ' a.date DESC';
            } elseif ($sort = $this->db->escape($_GET['sort']) == 'desc') {
                $sort = ' a.price DESC';
            } elseif ($sort = $this->db->escape($_GET['sort']) == 'asc') {
                $sort = ' a.price ASC';
            }
        }
        if (!empty($adId)) {
            $sql .= " and a.id_user=" . (int)$adId;
        }
        $sql .= " ORDER BY {$sort}";
        $this->affected_rows = $this->db->getAffectedRows($sql);//получаем общее количество записей без ЛИМИТа для пагинации
        if (!empty($_GET['page'])) {
            $page = (int)$_GET['page'] - 1;
        } else {
            $page = 0;
        }
        $perPage = Config::get('perPage');
        $start = $page * $perPage;
        $sql .= " LIMIT {$start}, {$perPage}";
//        die($sql);
        return $this->db->query($sql);


    }

    public function getPagination()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        return new Pagination(array(
            'itemsCount' => $this->getAffectedRows(),
            'itemsPerPage' => Config::get('perPage'),
            'currentPage' => $page
        ));
    }

    public function getAdByAdID($id)
    {
        $sql = "SELECT a.`id`, a.`title`,a.`text`, a.`date`, a.`id_categories`, a.`region`, a.`img`, a.`img_other`,a.`img_other2`, a.`is_active`, a.`price`,c.name,cc.name as parent,c.parent_id, a.id_user,u.name as userName,u.phone,u.email,u.registr_date
                    FROM `ads` a JOIN categories c
                    ON a.id_categories=c.id
                    JOIN categories cc ON cc.id=c.parent_id
                    JOIN users u ON a.id_user=u.user_id WHERE a.id={$id} limit 1";
//        die($sql);

        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }


    public function extractId($alias)
    {
        $parts = explode('-', $alias);
        $id = $this->db->escape(end($parts));
        return $id;
    }

    public function save_message($to_id, $from_id, $message, $ad_id, $ad_title)
    {
        $this->db->query("INSERT INTO user_messages (to_id,from_id, message,ad_id) VALUES ({$to_id},{$from_id},{$message},{$ad_id})");
        $mail = new Mail("sit_tis@mail.ru"); // Создаём экземпляр класса
        $mail->setFromName("Сообщения | MyBarter.UA"); // Устанавливаем имя в обратном адресе
        $from_user = $this->userInfo($from_id)[0];
        $to_user = $this->userInfo($to_id)[0];
        $mail->send("{$to_user['email']}", "Новое сообщение - $ad_title", "<h2>Вам пришло новое сообщение на MyBarter.UA по объявлению '{$ad_title}' </h2> <h4>От {$from_user['name']} - {$from_user['email']}. </h4><p>$message</p> <br/> <strong>Посмотреть все Ваши сообщения:</strong> <br/><a href='http://{$_SERVER['SERVER_NAME']}" . PRELINK . "users/messages' >Сообщения на MyBarter.UA</a>");
        return $this->db->getConnection()->affected_rows;

    }


}
