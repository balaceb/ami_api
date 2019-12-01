<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AchievedInfo
    {
        
        // object properties
        public $id;
        
        public $enroll_id;              // Unique system identifier to map learners to users. This ID is unique for each programme a learner enrolls for
        
        public $achieved_id;            // Certificate Number
        public $date;
        public $achieved_letter;        // aka SOR
        public $certificate;         
    }
    
    
    class Achieved extends AchievedInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ACHIEVED_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct()
        {
            $this->fmt = new Format();
            $db = new Database();
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        
        // read products
        public function readAll()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their Registration ID
        public function readByRegId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE reg_id='$regId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their Enroll ID
        public function readByEnrollId($enrollId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE enroll_id='$enrollId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their primary unique key
        public function readById($id)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        public function add()
        {
            if ('' != $this->enroll_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    enroll_id,
                    achieved_id,
                    date,
                    achieved_letter,
                    certificate
                )
                VALUES
                (
                    '$this->enroll_id',
                    '$this->achieved_id',
                    '$this->date',
                    '$this->achieved_letter',
                    '$this->certificate'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    achieved_id = '$this->achieved_id',
                    achieved_letter = '$this->achieved_letter',
                    certificate = '$this->certificate',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->enroll_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    achieved_id = '$this->achieved_id',
                    achieved_letter = '$this->achieved_letter',
                    certificate = '$this->certificate'
//                     date = '$this->date'
                WHERE
                    enroll_id = '$this->enroll_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->enroll_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    enroll_id = '$this->enroll_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>