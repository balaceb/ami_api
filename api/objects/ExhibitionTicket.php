<?php
/*
 * The exhibition ticket/packages will be hard coded on the homepage with a unique ID that will be stored in the DB and a registered sponsor will select and the 
 * selected package's ID will be sent to the server and it'll checked in the database to get the required info about that package.
 * 
 * The seminar admin will enter the package description and DB entries. These entries will be mapped to the seminar_id.
 * To build the package on the website, the system gets all unique seminar ids and displays them by package name.
 * 
 * This will be used to store each item offered for each ticket category.
 * E.g Standard Access has "regular seating". This will be one row in the db. And isDesc will be used to determine if that item is:
 *    - Tick ==> Item is available for that category
 *    - Cross ==> Item is not available for that category
 *    
 *    The aim is that all categories should have the same number of items so that they have the same height for beautification and presentation.
 * 
 * When creating the Tickets category view on the homepage, all these rows per category for that seminar will be read and then displayed.
 * 
 * Alternatively: It could be decided that the items of each category will be entered all at once as a comma or line-break separated list.
 *                And this will be split and displayed. In this case, isDesc will not be used.
 * NB: Only the next or upcoming seminar will be shown so that one at a time can be displayed.
 * 
 * */
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class ExhibitionTicketInfo
    {

        // object properties
        public $id;
        
        public $ticket_id;              // Unique system identifier for ticket
        public $seminar_id;             // Seminar to which package belongs
        public $name;                   // Ticket category/package name. Must be either: Standard, Pro, Premium Access or any other fixed/agreed names
        public $amount;                 // Ticket amount (in rands). Should be same for all entries with same $name and $seminar_id
        public $isDesc;                 // Is ticket Item part of package or not ==> Ticket or cross symbol. This field will be Yes or No
        public $desc;                   // Ticket item
        public $status;                 // Ticket status. May or may not be used
        public $date;                   // Date exhibition package was created
    }
    
    
    class ExhibitionTicket extends ExhibitionTicketInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_EXHIBITION_TICKET_TBL;
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
        
        
        // Read Ticket by Ticket ID
        public function readByTicketId($ticketId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE ticket_id='$ticketId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Ticket by Seminar ID
        public function readBySeminarId($seminarId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE seminar_id='$seminarId'";
            
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
            if ('' != $this->ticket_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    ticket_id,
                    seminar_id,
                    name,
                    amount,
                    isDesc,
                    desc,
                    status,
                    date
                )
                VALUES
                (
                    '$this->ticket_id',
                    '$this->seminar_id',
                    '$this->name',
                    '$this->amount',
                    '$this->isDesc',
                    '$this->desc',
                    '$this->status,
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    ticket_id = '$this->ticket_id',
                    seminar_id = '$this->seminar_id',
                    name = '$this->name',
                    amount = '$this->amount',
                    isDesc = '$this->isDesc',
                    desc = '$this->desc',
                    status = '$this->status'
//                     date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->ticket_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    ticket_id = '$this->ticket_id',
                    seminar_id = '$this->seminar_id',
                    name = '$this->name',
                    amount = '$this->amount',
                    isDesc = '$this->isDesc',
                    desc = '$this->desc',
                    status = '$this->status'
                WHERE
                    ticket_id = '$this->ticket_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->ticket_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    ticket_id = '$this->ticket_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>