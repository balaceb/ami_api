<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class SeminarInfo
    {
        
        // object properties
        public $id;
        
        public $seminar_id;             // Unique system identifier for seminars
        
        public $name;                   // Seminar Name
        public $topic;                  // Seminar topic or title
        public $desc;                   // Seminar description
        public $date;                   // Date seminar was created
        public $address;                // Street address where seminar will take place
        public $municipality;           // Municipality where seminar will take place
        public $province;               // Province where seminar will take place
        public $email;                  // Seminar Contact Email
        public $mobile;                 // Seminar Contact number
        public $fixed;                  // Seminar Contact number
        
        public $days;                   // Number of days the seminar will hold
        public $start;                  // Start date of seminar        
        public $attendees;              // Max. Number of spaces available for attendees
        public $speakers;               // Max. Number of spaces available for speakers
        public $exhibitors;             // Max. Number of spaces available for exhibitors
        
        public $status;                 // Seminar status. If enabled or disabled
        
    }
    
    
    class Seminar extends SeminarInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_SEMINAR_TBL;
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
        
        
        // Read Seminars by Seminar ID
        public function readBySeminarId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE seminar_id='$regId'";
            
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
                    seminar_id,
                    name,
                    topic,
                    desc,
                    date,
                    address,
                    municipality,
                    province,
                    email,
                    mobile,
                    fixed,
                    days,
                    start,
                    attendees,
                    speakers,
                    exhibitors,
                    status
                )
                VALUES
                (
                    '$this->seminar_id',
                    '$this->name',
                    '$this->topic',
                    '$this->desc',
                    '$this->date',
                    '$this->address',
                    '$this->municipality',
                    '$this->province',
                    '$this->email',
                    '$this->mobile',
                    '$this->fixed',
                    '$this->days',
                    '$this->start',
                    '$this->attendees',
                    '$this->speakers',
                    '$this->exhibitors',
                    '$this->status'
                )
                ON DUPLICATE KEY UPDATE
//                     seminar_id      = '$this->seminar_id',
                    name     = '$this->name',
                    topic = '$this->topic',
                    desc = '$this->desc',
                   //a date = '$this->date',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    email = '$this->email',
                    mobile = '$this->mobile',
                    fixed = '$this->fixed',
                    days = '$this->days',
                    start = '$this->start',
                    attendees = '$this->attendees',
                    speakers = '$this->speakers',
                    exhibitors = '$this->exhibitors',
                    status = '$this->status'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->seminar_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name     = '$this->name',
                    topic = '$this->topic',
                    desc = '$this->desc',
//                     date = '$this->date',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    email = '$this->email',
                    mobile = '$this->mobile',
                    fixed = '$this->fixed',
                    days = '$this->days',
                    start = '$this->start',
                    attendees = '$this->attendees',
                    speakers = '$this->speakers',
                    exhibitors = '$this->exhibitors',
                    status = '$this->status'
                WHERE
                    seminar_id = '$this->seminar_id'";
                
                return $this->conn->update($query);
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->seminar_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    seminar_id = '$this->seminar_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>