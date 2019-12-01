<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class SpeakerInfo
    {
        
        // object properties
        public $id;
        
        public $speaker_id;            // Unique system identifier for Speakers.
        
        public $title;
        public $fname;
        public $lname;
        
        public $sex;
        public $dob;
        
        public $username;
        public $password;
        
        public $address;                // Speaker's contact address
        public $municipality;           // Speaker's municipality or city
        public $province;               // Speaker's province
        public $email;                  // Speaker Contact Email
        public $mobile;                 // Speaker Contact number
        public $fixed;                  // Speaker Contact number
        
        public $idc_num;                // ID Card number
        public $idc;                    // ID Card file
        public $cv;                     // Curriculum Vitae
        
        public $pic;                    // Speaker's Pic 
        public $date;                   // Date Speaker registered
        
        public $status;                 // To Disable/Enable user account
    }
    
    
    class Speaker extends SpeakerInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_SPEAKER_TBL;
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
        
        
        // Read Speaker by Speaker ID
        public function readBySpeakerId($speakerId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE speaker_id='$speakerId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read speaker by their primary unique key
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
            if ('' != $this->speaker_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    speaker_id,
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
                    pic,
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
                    '$this->speaker_id',
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
                    '$this->pic',
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
                    pic = '$this->pic',
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
            if ('' != $this->speaker_id)
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
                    pic = '$this->pic',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    status = '$this->status'
                WHERE
                    speaker_id = '$this->speaker_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function updatePwd()
        {
            if ('' != $this->speaker_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password = '$this->password',
                WHERE
                    speaker_id = '$this->speaker_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->speaker_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    speaker_id = '$this->speaker_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>