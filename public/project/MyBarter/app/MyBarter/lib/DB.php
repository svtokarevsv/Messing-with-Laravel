<?php
namespace MyBarter\lib;
class DB
{
    protected $connection;
    private static $instance;
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;

    public static function getInstance()
    {
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->host=Config::get('db.host');
        $this->user=Config::get('db.user');
        $this->password=Config::get('db.password');
        $this->db_name=Config::get('db.db_name');
        /*$this->connection = new \mysqli($this->host,  $this->user, $this->password, $this->db_name);*/
        try {
            $this->connection = new \PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->password);
            $this->connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

        }catch(\PDOException $e) {
            echo $e->getMessage();
        }
        $this->connection->query('SET NAMES UTF8');

/*        if (mysqli_connect_error()) {
            throw new \Exception('Could not connect to DB');

        }*/
    }

    private function __clone(){}
    private function __sleep(){}

    private function __wakeup(){}

    public function query($sql)
    {
        if (!$this->connection) {
            return false;
        }
        $result = $this->connection->query($sql);
        if (is_bool($result)) {
            return $result;
        }
        $data = array();
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }
    public function exec($sql)
    {
        if (!$this->connection) {
            return false;
        }
        $result = $this->connection->query($sql);
    }

    public function prepared_query($sql,array $data=null)
    {
        if (!$this->connection) {
            return false;
        }
        $result=$this->connection->prepare($sql);
        $result->execute($data);
        $data = array();
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }
    public function prepared_exec($sql,array $data=null)
    {
        if (!$this->connection) {
            return false;
        }
        $result=$this->connection->prepare($sql);
//        echo "<pre>";
//        var_dump($result).var_dump($data);
        $result->execute($data);
        return $result->rowCount();
    }

    public function escape($str=false)
    {
        return $this->connection->quote($str);
    }


    public function getAffectedRows($sql)
    {
//        echo "<pre>";
//        die(var_dump($this->query($sql)));
            return count(self::query($sql));
    }

    /**
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

}