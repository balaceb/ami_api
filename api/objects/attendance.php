<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AttendanceInfo
    {
        // object properties
        public $id;
        public $attendance_id;
        public $seminar_id;         // Seminar the attendance register is for
        public $user_id;            // user's unique ID. User who attended
        public $attendance_date;    // Date the user attended
        public $date;               // Date user's attendance was created
    }
    
    class Attendance extends AttendanceInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ATTENDANCE_TBL;
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
        
        
        // Read Attendance by Attendance ID
        public function readByAttendanceId($attendanceId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE attendance_id='$attendanceId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Attendance by unique Key / ID
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
            if ('' != $this->attendance_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    attendance_id,
                    seminar_id,
                    user_id,
                    attendance_date,
                    date
                )
                VALUES
                (
                    '$this->attendance_id',
                    '$this->seminar_id',
                    '$this->user_id',
                    '$this->attendance_date',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    attendance_id = '$this->attendance_id',
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    attendance_date = '$this->attendance_date'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->attendance_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    attendance_date = '$this->attendance_date'
                WHERE
                    attendance_id = '$this->attendance_id'";
                
                return $this->conn->update($query);
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->attendance_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    attendance_id = '$this->attendance_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>