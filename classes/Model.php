<?php

namespace classes;

use PDO;

/**
 * Main Model
 */
class Model
{
    public $db;
    public $errors;

    function __construct() {
        $this->db = new Db(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
        $this->db->setFetchMode(PDO::FETCH_ASSOC);
        $this->errors = [];
    }
}
