<?php
namespace Db;

use PDOException;
use PDO;

class Database
{
    public string $host = 'mysql';
    public string $dbname = 'app';
    public string $table = 'products';
    public string $user = 'app';
    public string $pass = 'app';
    public $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public function getDbConnection() {
        return $this->db;
    }

    /**
     * создадание БД,таблицы и добавление данных
    */
    public function init() {
        $this->db->exec("CREATE DATABASE IF NOT EXISTS $this->dbname");
        $this->db->exec("CREATE TABLE IF NOT EXISTS $this->table (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              name VARCHAR(255) COMMENT 'название',
              price decimal(10, 2) COMMENT 'цена',
              description VARCHAR(255) COMMENT 'описание',
              weight decimal(5, 2) COMMENT 'вес',
              article VARCHAR(128) COMMENT 'артикул',
              PRIMARY KEY  (id)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COMMENT='товары'
        ");

        $this->db->exec("INSERT INTO $this->table (name, price, description, weight, article) 
            VALUES 
               ('LG', '10000.12', 'телефон LG', '100', '111'),
               ('SAMSUNG', '13000.12', 'телефон SAMSUNG', '100', '222'),
               ('HUAWEI', '15000.12', 'телефон HUAWEI', '90', '333')
        ");
    }
}
