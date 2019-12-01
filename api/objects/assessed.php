<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AssessedInfo
    {
        // object properties
        public $id;
        public $enroll_id;                      // Unique system identifier to map learners to users. This ID is unique for each programme a learner enrolls for
        public $assessed_id;                    // Unique assessed ID
        public $assessor;                       // Assessor's name
        public $date;                           // Assessment date
        public $script;                         // Assessed Script filename+locaiton on server
        public $module;                         // Assessed Script type - E.g Formative Module 1, Summative Module 2
//         public $report;                         // Assessment report
//         public $report_type;                    // Assessment report type. E.g General Report, Individual Report, etc
//         public $indiv_report;                   // Assessment report
//         public $gen_report;                     // Assessment report
        public $moderate;                       // Moderation Flag. 1 ==> If learner's script will be moderated
        public $competence;                     // Competent/Not Competent
        public $status;                         // Flag that indicates if learner accepted assessment decision. 1 ==> Accepted | 2 ==> Appealed | 3 ==> Appeal Resolved
    }
    
    
    class Assessed extends AssessedInfo
    {
        // database connection and table name
        private $conn;
        private $table_name = DB_ASSESSED_TBL;
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
                    assessed_id, 
                    assessor, 
                    date, 
                    script,
                    module,
                    moderate,
                    competence,
                    status
                )
                VALUES
                (
                    '$this->enroll_id', 
                    '$this->assessed_id', 
                    '$this->assessor', 
                    '$this->date', 
                    '$this->script',
                    '$this->module',
                    '$this->moderate',
                    '$this->competence',
                    '$this->status'
                )
                ON DUPLICATE KEY UPDATE
                    assessor = '$this->assessor',
                    script = '$this->script',
                    module = '$this->module',
                    moderate = '$this->moderate',
                    competence = '$this->competence',
                    date = '$this->date',
                    status = '$this->status'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->assessed_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    assessor = '$this->assessor',
                    script = '$this->script',
                    module = '$this->module',
                    moderate = '$this->moderate',
                    competence = '$this->competence',
//                     date = '$this->date',
                    status = '$this->status'
                WHERE
                    assessed_id = '$this->assessed_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->assessed_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    assessed_id = '$this->assessed_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>