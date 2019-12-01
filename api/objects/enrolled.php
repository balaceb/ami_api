<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    include_once '../objects/user.php';
    
    class EnrolledInfo{
        
        // object properties
        public $id;
        
        public $status;                 // Registered, Enrolled, Facilitated, Assessed, Moderated, Ext-Moderated, Achieved
        
        public $reg_id;                 // The registration ID here is used to map enrolled learners to system users. Its a system wide uniqued identifier much like the email.
        
        public $enroll_id;
        public $enroll_date;
        public $enroll_letter;
        
        public $session_id;             // The session ID is a unique ID for each session of the programme. Each session of the programme must have a course and a course has unit standards. 
        
    }
    
    
    class Enrolled extends EnrolledInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ENROLLED_TBL;
        private $fmt;
        
        // constructor with $db as database connection
        public function __construct(){
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
                    reg_id, session_id, enroll_id, enroll_letter, enroll_date, status 
                )
                VALUES
                (
                    '$this->reg_id', '$this->session_id', '$this->enroll_id', '$this->enroll_letter', '$this->enroll_date', '$this->status'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    reg_id = '$this->reg_id',
                    session_id = '$this->session_id',
                    enroll_letter = '$this->enroll_letter',
                    enroll_date = '$this->enroll_date',
                    status = '$this->status'
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
                    reg_id = '$this->reg_id',
                    session_id = '$this->session_id',
                    enroll_letter = '$this->enroll_letter',
//                     enroll_date = '$this->enroll_date',
                    status = '$this->status'
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