<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AppealInfo
    {
        // object properties
        public $id;
        public $enroll_id;
        public $complaint_id;       // complaint ID. Unique ID to identify a complaint
        public $complaint;          // Learner's complaint/appeal
        public $module;             // Module being appealed
        public $script;             // Assessed Script being appealed
        public $assessor;           // Assessor who assessed the script
        public $reason;             // Assessor's Reason
        public $decision;           // Moderator#s Decision
        public $status;             // Appeal Status
        public $date;               // Date of appeal
    }
    
    class Appeals extends AppealInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_APPEAL_TBL;
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
        
        
        // Read user by Enrollment ID
        public function readByEnrollId($enrollId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE enroll_id='$enrollId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read user by Complaint ID
        public function readByComplaintId($complaintId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE complaint_id='$complaintId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read User by unique Key / ID
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
            if ('' != $this->complaint_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    enroll_id,
                    complaint_id,
                    complaint,
                    module,
                    script,
                    assessor,
                    reason,
                    decision,
                    status,
                    date
                )
                VALUES
                (
                    '$this->enroll_id',
                    '$this->complaint_id',
                    '$this->complaint',
                    '$this->module',
                    '$this->script',
                    '$this->assessor',
                    '$this->reason',
                    '$this->decision',
                    '$this->status',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    complaint = '$this->complaint',
                    module = '$this->module',
                    script = '$this->script',
                    assessor = '$this->assessor',
                    reason = '$this->reason',
                    decision = '$this->decision',
                    status = '$this->status',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->complaint_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
//                     enroll_id = '$this->enroll_id',
                    complaint = '$this->complaint',
                    module = '$this->module',
                    script = '$this->script',
                    assessor = '$this->assessor',
                    reason = '$this->reason',
                    decision = '$this->decision',
                    status = '$this->status'
//                     date = '$this->date'
                WHERE
                    complaint_id = '$this->complaint_id'";
                
                return $this->conn->update($query);
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->complaint_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    complaint_id = '$this->complaint_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>