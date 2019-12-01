<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class SponsorInfo
    {
        
        // object properties
        public $id;
        
        public $sponsor_id;            // Unique system identifier for sponsors.
        
        public $title;
        public $fname;
        public $lname;
        
        public $sex;
        public $dob;
        
        public $username;
        public $password;
        
        public $address;                // Sponsor's contact address
        public $municipality;           // Sponsor's municipality or city
        public $province;               // Sponsor's province
        public $email;                  // Sponsor's Contact Email
        public $mobile;                 // Sponsor's Contact number
        public $fixed;                  // Sponsor's Contact number
        
        public $idc_num;                // ID Card number
        public $idc;                    // ID Card file
        
        public $logo;                   // Sponsor's Logo    
        public $date;                   // Date sponsor registered
        
        public $status;                 // To disable account
    }
    
    
    class Sponsor extends SponsorInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_SPONSOR_TBL;
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
        
        
        // Read Sponsor by Sponsor ID
        public function readBySponsorId($sponsorId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE sponsor_id='$sponsorId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read sponsor by their primary unique key
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
            if ('' != $this->sponsor_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    sponsor_id,
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
                    address,
                    municipality,
                    province,
                    tel,
                    cell,
                    logo,
                    status,
                    date
                )
                VALUES
                (
                    '$this->sponsor_id',
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
                    '$this->address',
                    '$this->municipality',
                    '$this->province',
                    '$this->tel',
                    '$this->cell',
                    '$this->logo',
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
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    logo = '$this->logo',
                    status = '$this->status'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->sponsor_id)
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
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    logo = '$this->logo',
                    status = '$this->status'
                WHERE
                    sponsor_id = '$this->sponsor_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function updatePwd()
        {
            if ('' != $this->sponsor_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password = '$this->password',
                WHERE
                    sponsor_id = '$this->sponsor_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->sponsor_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    sponsor_id = '$this->sponsor_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>