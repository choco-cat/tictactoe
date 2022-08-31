<?php
namespace classes;
use PDO;

class Db {

    private $db;

    public function __construct($dbHost, $dbName, $dbUser, $dbPassword){
        $this->db = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset=utf8', $dbUser, $dbPassword);
    }

    private function exec($request, $values = null){
        $result = $this->db->prepare($request);
        $result->execute($values);
        return $result;
    }

    public function setFetchMode($fetchMode){
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    }

    public function execute($request, $values = array()){
        $results = self::exec($request, $values);
        return ($results) ? true : false;
    }

    public function fetch($request, $values = null, $all = true) {
        $results = self::exec($request, $values);
        return ($all) ? $results->fetchAll() : $results->fetch();
    }
}