<?php 
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class ContactInfo
    {
        // object properties
        public $address;
        public $municipality;
        public $province;
        public $tel;
        public $cell;
    }
    
    
    class UserContact extends ContactInfo
    {
        private $table_name = DB_CONTACT_TBL;
        private $conn;
        private $fmt;
        
        // constructor with $db as database connection
        public function __construct(){
            $this->fmt = new Format();
            $db = new Database();
            $this->conn = $db;
        }
        
        // read products
        public function readAllUsers()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        // Read Contact by Registration ID
        public function readContactByRegId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE reg_id='$regId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        // Read Contact by unique ID
        public function readContactById($id)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
    }

?>