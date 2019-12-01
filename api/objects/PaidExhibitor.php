<?php
/*
 * After an exhibitor successfully makes a payment, the details will be stored
 * */
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class PaidExhibitorInfo
    {

        // object properties
        public $id;
        public $payment_id;             // Unique system identifier for each payment
        public $user_id;                // user ID of user who made the payment
        public $seminar_id;             // Seminar user made payment for
        public $amount;                 // Amount paid
        public $name;                   // Package name
        public $reference;              // Payment Reference. E.g. PayPal reference
        public $date;                   // Date payment was made
    }
    
    
    class PaidExhibitor extends PaidExhibitorInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_EXHIBITION_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct()
        {
            $this->fmt = new Format();
            $db = new Database();
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        
        // read all
        public function readAll()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name;
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Payment info by Payment ID
        public function readByPaymentId($paymentId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE payment_id='$paymentId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Payment info by Seminar ID
        public function readBySeminarId($seminarId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE seminar_id='$seminarId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Payment info by User ID
        public function readByUserId($userId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id='$userId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Payment info by their primary unique key
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
            if ('' != $this->payment_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    payment_id,
                    seminar_id,
                    user_id,
                    name,
                    amount,
                    reference,
                    date
                )
                VALUES
                (
                    '$this->payment_id',
                    '$this->seminar_id',
                    '$this->user_id',
                    '$this->name',
                    '$this->amount',
                    '$this->reference',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    payment_id = '$this->payment_id',
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    name = '$this->name',
                    amount = '$this->amount',
                    reference = '$this->reference'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->payment_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    payment_id = '$this->payment_id',
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    name = '$this->name',
                    amount = '$this->amount',
                    reference = '$this->reference'
                WHERE
                    payment_id = '$this->payment_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->payment_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    payment_id = '$this->payment_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>