<?php
/*
 * The packages will be hard coded on the homepage with a unique ID that will be stored in the DB and a registered sponsor will select and the 
 * selected package's ID will be sent to the server and it'll checked in the database to get the required info about that package.
 * 
 * Alternatively, the seminar admin can use a rich-text editor to input the package offers as a list
 * 
 * The seminar admin will enter the package description as a list and the server admin will get this info and hard code that on the homepage.
 * 
 * 
 * NB: Only sponsors who have paid will have their logos displayed on the website
 * */
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class SponsorshipInfo
    {

        // object properties
        public $id;
        
        public $sponsorship_id;         // Unique system identifier for paid sponsorships
        public $sponsor_id;             // Unique system identifier for sponsor who has made sponsorship payment.
        public $amount;                 // Sponsorship amount
        public $receipt;                // Sponsorship Payment receipt
        public $agreement;              // Sponsorship agreement
        public $status;                 // Payment/Sponsorship status. May or may not be used
        public $date;                   // Date sponsorship payment was made
    }
    
    
    class Sponsorship extends SponsorshipInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_SPONSORSHIP_ADVERT_TBL;
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
        
        
        // Read Sponsorship by Sponsorship ID
        public function readBySonsorshipId($sponsorshipId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE advert_id='$sponsorshipId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read sponsorship by their primary unique key
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
            if ('' != $this->sponsorship_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    sponsorship_id,
                    sponsor_id,
                    amount,
                    receipt,
                    agreement,
                    status,
                    date
                )
                VALUES
                (
                    '$this->sponsorship_id',
                    '$this->sponsor_id',
                    '$this->amount',
                    '$this->receipt',
                    '$this->agreement',
                    '$this->status,
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    sponsorship_id = '$this->sponsorship_id',
                    sponsor_id = '$this->sponsor_id',
                    amount = '$this->amount',
                    receipt = '$this->receipt',
                    agreement = '$this->agreement',
                    status = '$this->status'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->sponsorship_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    sponsorship_id = '$this->sponsorship_id',
                    sponsor_id = '$this->sponsor_id',
                    amount = '$this->amount',
                    receipt = '$this->receipt',
                    agreement = '$this->agreement',
                    status = '$this->status'
                WHERE
                    sponsorship_id = '$this->sponsorship_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->sponsorship_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    sponsorship_id = '$this->sponsorship_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>