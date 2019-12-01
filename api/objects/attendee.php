<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AttendeeInfo
    {
        
        // object properties
        public $id;
        
        public $attendee_id;            // Unique system identifier for attendees.
        
        public $title;
        public $fname;
        public $lname;
        
        public $sex;
        public $dob;
        
        public $username;
        public $password;
        
        public $address;                // Attendee's contact address
        public $municipality;           // Attendee's municipality or city
        public $province;               // Attendee's province
        public $email;                  // Attendee Contact Email
        public $mobile;                 // Attendee Contact number
        public $fixed;                  // Attendee Contact number
        
        public $idc_num;                // ID Card number
        public $idc;                    // ID Card file
        public $cv;                     // Curriculum Vitae
        
        public $date;                   // Date attendee registered
        
        public $status;                 // If user is a paying user
    }
    
    
    class Attendee extends AttendeeInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ATTENDEE_TBL;
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
        
        
        // Read Attendee by Attendee ID
        public function readByAttendeeId($attendeeId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE attendee_id='$attendeeId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read attendee by their primary unique key
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
            if ('' != $this->attendee_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    attendee_id,
                    title,
                    fname,
                    lname,
                    username,
                    email,
                    sex,
                    dob,
                    idc_num,
                    password,
                    idc,
                    cv,
                    address,
                    municipality,
                    province,
                    tel,
                    cell,
                    status,
                    date
                )
                VALUES
                (
                    '$this->attendee_id',
                    '$this->title',
                    '$this->fname',
                    '$this->lname',
                    '$this->username',
                    '$this->email',
                    '$this->sex',
                    '$this->dob',
                    '$this->idc_num',
                    '$this->password',
                    '$this->idc',
                    '$this->cv',
                    '$this->address',
                    '$this->municipality',
                    '$this->province',
                    '$this->tel',
                    '$this->cell',
                    '$this->status',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    title = '$this->title',
                    fname = '$this->fname',
                    lname = '$this->lname',
                    username = '$this->username',
                    email = '$this->email',
                    sex = '$this->sex',
                    dob = '$this->dob',
                    idc_num = '$this->idc_num',
                    idc = '$this->idc',
                    cv = '$this->cv',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    status = '$this->status'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->attendee_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    title = '$this->title',
                    fname = '$this->fname',
                    lname = '$this->lname',
                    username = '$this->username',
                    email = '$this->email',
                    sex = '$this->sex',
                    dob = '$this->dob',
                    idc_num = '$this->idc_num',
                    idc = '$this->idc',
                    cv = '$this->cv',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    status = '$this->status'
                WHERE
                    attendee_id = '$this->attendee_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function updatePwd()
        {
            if ('' != $this->attendee_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password = '$this->password',
                WHERE
                    attendee_id = '$this->attendee_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->attendee_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    attendee_id = '$this->attendee_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>