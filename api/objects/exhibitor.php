<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class ExhibitorInfo
    {
        
        // object properties
        public $id;
        
        public $exhibitor_id;            // Unique system identifier for exhibitors.
        
        public $title;
        
        public $fname;
        public $lname;
        
        public $sex;
        public $dob;
        
        public $username;
        public $password;
        
        public $address;                // Exhibitor's contact address
        public $municipality;           // Exhibitor's municipality or city
        public $province;               // Exhibitor's province
        public $email;                  // Exhibitor's Contact Email
        public $mobile;                 // Exhibitor's Contact number
        public $fixed;                  // Exhibitor's Contact number
        
        public $idc_num;                // ID Card number
        public $idc;                    // ID Card file
        
        public $date;                   // Date exhibitor registered
        
        public $status;                 // To disable account
    }
    
    
    class Exhibitor extends ExhibitorInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_EXHIBITOR_TBL;
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
        
        
        // Read Exhibitor by Exhibitor ID
        public function readByExhibitorId($exhibitorId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE exhibitor_id='$exhibitorId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read exhibitor by their primary unique key
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
            if ('' != $this->exhibitor_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    exhibitor_id,
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
                    status,
                    date
                )
                VALUES
                (
                    '$this->exhibitor_id',
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
                    status = '$this->status'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->exhibitor_id)
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
                    status = '$this->status'
                WHERE
                    exhibitor_id = '$this->exhibitor_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function updatePwd()
        {
            if ('' != $this->exhibitor_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password = '$this->password',
                WHERE
                    exhibitor_id = '$this->exhibitor_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->exhibitor_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    exhibitor_id = '$this->exhibitor_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>