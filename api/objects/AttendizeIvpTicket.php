<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AttendizeIvpTicketInfo
    {

        // object properties
        public $ticket_id;              // Event primary key. Used to identify ticket tpyes for event
        public $ticket_title;           // Event Title
        public $ticket_cost;            // Event description / About event
        public $ticket_count;           // Event image
        public $ticket_sale_start;      // Event start date
        public $ticket_sale_end;        // Event end date
        public $ticket_sold;            // Event Venue name
        public $ticket_event_id;        // Primary of organiser account/user that created event
        public $ticket_desc;            // Event Organiser
        public $date;                   // Date event was created 
    }
    
    
    class AttendizeIvpTicket extends AttendizeIvpTicketInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ATTENDIZE_IVP_TICKET_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct()
        {
            $this->fmt = new Format();
            
            $db = '';
            
            $whitelist = array(
                '127.0.0.1',
                '::1'
            );
            
            
            if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            {
                $db = new Database('localhost', 'attendize', '', '');
            }
            else
            {
                $db = new Database('localhost', 'cashtwo5_attendize', '', '');   // ToDo: Change dbname and dbhost accordingly
            }
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        
        // read products
        public function readAll()
        {
            // select all query
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY price DESC";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read event by their primary unique key
        public function readById($id)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read event(s) by organiser id
        public function readByEventId($id)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE event_id='$id'" . " ORDER BY price DESC";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        public function add()
        {
            if ('' != $this->ticket_title)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    title,
                    price,
                    quantity_available,
                    start_sale_date,
                    end_sale_date,
                    description,
                    quantity_sold,
                    event_id,
                    created_at
                )
                VALUES
                (
                    '$this->ticket_title',
                    '$this->ticket_cost',
                    '$this->ticket_count',
                    '$this->ticket_sale_start',
                    '$this->ticket_sale_start',
                    '$this->ticket_desc',
                    '$this->ticket_sold',
                    '$this->ticket_event_id',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    title = '$this->ticket_title',
                    price = '$this->ticket_cost',
                    quantitiy_available = '$this->ticket_count',
                    start_sale_date = '$this->ticket_sale_start',
                    end_sale_date = '$this->ticket_sale_start',
                    quantity_sold = '$this->ticket_sold',
                    description = '$this->ticket_desc'
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
                    title = '$this->ticket_title',
                    price = '$this->ticket_cost',
                    quantitiy_available = '$this->ticket_count',
                    start_sale_date = '$this->ticket_sale_start',
                    end_sale_date = '$this->ticket_sale_start',
                    quantity_sold = '$this->ticket_sold',
                    description = '$this->ticket_desc'
                WHERE
                    id = '$this->ticket_id'";
                
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
                    id = '$this->ticket_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>