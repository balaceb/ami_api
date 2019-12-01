<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class ReportInfo
    {
        // object properties
        public $id;
        public $enroll_id;
        public $report_id;
        public $reporter;           // Author of the report
        public $report;             // Report
        public $type;               // Type or category of report. E.g Individual Assessor Report
        public $desc;
        public $date;               // Date report of was issued or made.
    }
    
    class Reports extends ReportInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_REPORT_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct(){
            $this->fmt = new Format();
            $db = new Database();
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        
        // read products
        public function readAllReports()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read user by Report ID
        public function readByReportId($repId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE report_id='$repId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Report by Enroll ID
        public function readByEnrollId($enrollId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE enroll_id='$enrollId'";
            
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
            if ('' != $this->report_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    enroll_id,
                    report_id,
                    report,
                    type,
                    desc,
                    reporter,
                    date
                )
                VALUES
                (
                    '$this->enroll_id',
                    '$this->report_id',
                    '$this->report',
                    '$this->type',
                    '$this->desc',
                    '$this->reporter',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    report = '$this->report',
                    type = '$this->type',
                    desc = '$this->desc',
                    reporter = '$this->reporter',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->report_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    report = '$this->report',
//                     enroll_id = '$this->enroll_id',
                    type = '$this->type',
                    desc = '$this->desc',
                    reporter = '$this->reporter'
//                     date = '$this->date'
                WHERE
                    report_id = '$this->report_id'";
                
                return $this->conn->update($query);
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->report_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    report_id = '$this->report_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>