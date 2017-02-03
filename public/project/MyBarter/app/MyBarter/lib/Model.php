<?php
namespace MyBarter\lib;
class Model
{
    protected $db;
    protected $affected_rows;
    public function __construct()
    {
        $this->db=App::$db;
    }

    /**
     * @return mixed
     */
    public function getAffectedRows()
    {
        return $this->affected_rows;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    public function userInfo($id)
    {
        $sql = "select * from users WHERE user_id={$id} LIMIT 1";
//die(var_dump($_SESSION).$sql);

        return $this->db->query($sql);
    }
}
