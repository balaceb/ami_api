<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    include_once '../objects/contact.php';
    
    class UserInfo
    {
        // object properties
        public $id;
        public $reg_id;
        
        public $title;
        public $fname;
        public $lname;
        public $username;
        public $email;
        public $sex;
        public $dob;
        public $idc_num;
        public $password;
        public $role;
        
        // ID and qualification
        public $idc;            // This will be a ref/link to the ID Card file or Blob??
        public $cv;             // This will be a ref/link to the CV file
        
        // Contact Info
        public $address;
        public $municipality;
        public $province;
        public $tel;
        public $cell;
        public $status;         // Used to enable or disable user account
        public $date;         // Date Account was created
    }
    
    class Users extends UserInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_USER_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct(){
            $this->fmt = new Format();
            $db = new Database();
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        // read products
        public function readAllUsers()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        // Read user by Registration ID
        public function readUserByRegId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE reg_id='$regId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        // Read User by unique ID
        public function readUserById($id)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        public function add()
        {
            if ('' != $this->reg_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    title,
                    fname,
                    lname,
                    username,
                    email,
                    sex,
                    dob,
                    idc_num,
                    password,
                    role,
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
                    '$this->title',
                    '$this->fname',
                    '$this->lname',
                    '$this->username',
                    '$this->email',
                    '$this->sex',
                    '$this->dob',
                    '$this->idc_num',
                    '$this->password',
                    '$this->role',
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
                    password = '$this->password',
                    role = '$this->role',
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
            if ('' != $this->reg_id)
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
                    password = '$this->password',
                    role = '$this->role',
                    idc = '$this->idc',
                    cv = '$this->cv',
                    address = '$this->address',
                    municipality = '$this->municipality',
                    province = '$this->province',
                    tel = '$this->tel',
                    cell = '$this->cell',
                    status = '$this->status'
//                     date = '$this->date'
                WHERE
                    reg_id = '$this->reg_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->reg_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    reg_id = '$this->reg_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>