<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    // Venue and address info are contained in the session info. Needless to have venue and address here again. 
    
    class FacilitatedInfo
    {
        
        // object properties
        public $id;
        public $enroll_id;                     // Unique system identifier to map learners to users. This ID is unique for each programme a learner enrolls for
        public $facilitator;                    // Facilitator's name
        public $date;                           // Facilitation date
//         public $report;                         // Report
//         public $report_type;                    // Report Type. E.g General Report
        public $status;                         // Flag indicating if learner was facilitated. Learner has to agree. 0 ==> Not Agreed
    }
    
    
    class Facilitated extends FacilitatedInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_FACILITATED_TBL;
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
                    enroll_id, facilitator, date, status
                )
                VALUES
                (
                    '$this->enroll_id', '$this->facilitator', '$this->date', '$this->status'
                ) 
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    facilitator = '$this->facilitator',
                    date = '$this->date',
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
                    facilitator = '$this->facilitator',
//                     date = '$this->date',
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