<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class AttendizeIvpEventInfo
    {

        // object properties
        public $event_id;               // Event primary key. Used to identify ticket tpyes for event
        public $event_title;            // Event Title
        public $event_desc;             // Event description / About event
        public $event_details;          // Event details like video link and maybe in the future: package details for Standard, VIP, VVIP
        public $event_img;              // Event image
        public $event_start;            // Event start date
        public $event_end;              // Event end date
        public $event_venue;            // Event Venue name
        public $event_city;             // Event Venue City
        public $event_addr1;            // Event Venue Address 1
        public $event_addr2;            // Event Venue Address 2
        public $event_postcode;         // Event Venue Postcode
        public $event_author_id;        // Primary of organiser account/user that created event
        public $organiser_id;           // Event Organiser
        public $symbol_left;            // Event Currency Symbol
        public $isEventExpired;         // True if event has already passed
        public $isEventDisabled;        // True if event is disabled
        public $date;                   // Date event was created 
    }
    
    
    class AttendizeIvpEvent extends AttendizeIvpEventInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_ATTENDIZE_IVP_EVENT_TBL;
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
            
            // change db name accordingly
            if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            {
                $db = new Database('localhost', 'attendize', '', '');
            }
            else 
            {
               $db = new Database('localhost', 'cashtwo5_attendize', '', ''); 
            }
            
            
            $this->conn = $db;
            
            date_default_timezone_set('Africa/Johannesburg');
        }
        
        
        // read products
        public function readAll()
        {
            // select all query
            $query = "SELECT " . $this->table_name . ".*, currencies.symbol_left, currencies.code FROM " . $this->table_name . " JOIN currencies ON " . $this->table_name . ".currency_id=currencies.id ORDER BY start_date DESC";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read event by their primary unique key
        public function readById($id)
        {
            // select query
            $query = "SELECT " . $this->table_name . ".*, currencies.symbol_left, currencies.code FROM " . $this->table_name . " JOIN currencies ON " . $this->table_name . ".currency_id=currencies.id WHERE '$this->table_name'.id='$id' ORDER BY start_date ASC";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read event(s) by organiser id
        public function readByOrganiserId($id)
        {
            // select query
            $query = "SELECT " . $this->table_name . ".*, currencies.symbol_left, currencies.code FROM " . $this->table_name . " JOIN currencies ON " . $this->table_name . ".currency_id=currencies.id WHERE " . $this->table_name.".organiser_id='$id' ORDER BY start_date ASC";
            
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        public function add()
        {
            if ('' != $this->event_title)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    title,
                    description,
                    details,
                    bg_image_path,
                    start_date,
                    end_date,
                    location,
                    venue_name,
                    event_city,
                    event_addr1,
                    event_addr2,
                    event_postcode,
                    account_id,
                    organiser_id,
                    symbol_left,
                    created_at
                )
                VALUES
                (
                    '$this->event_title',
                    '$this->event_desc',
                    '$this->event_details',
                    '$this->event_img',
                    '$this->event_start',
                    '$this->event_end',
                    '$this->event_loc',
                    '$this->event_venue',
                    '$this->event_city',
                    '$this->event_addr1',
                    '$this->event_addr2',
                    '$this->event_postcode',
                    '$this->event_author_id',
                    '$this->organiser_id',
                    '$this->symbol_left',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    title = '$this->event_title',
                    description = '$this->event_desc',
                    details, = '$this->event_details',
                    bg_image_path = '$this->event_img',
                    start_date = '$this->event_start',
                    end_date = '$this->event_end',
                    venue_name = '$this->event_venue',
                    location_state = '$this->event_city',
                    location_address_line_1 = '$this->event_addr1',
                    location_address_line_2 = '$this->event_addr2',
                    location_post_code = '$this->event_postcode',
                    symbol_left = '$this->symbol_left'
//                     user_id = '$this->event_author_id'
//                     organiser_id = '$this->organiser_id'
//                     created_at = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->event_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    title = '$this->event_title',
                    description = '$this->event_desc',
                    details, = '$this->event_details',
                    bg_image_path = '$this->event_img',
                    start_date = '$this->event_start',
                    end_date = '$this->event_end',
                    venue_name = '$this->event_venue',
                    location_state = '$this->event_city',
                    location_address_line_1 = '$this->event_addr1',
                    location_address_line_2 = '$this->event_addr2',
                    location_post_code = '$this->event_postcode'
                    symbol_left = '$this->symbol_left'
//                     user_id = '$this->event_author_id'
//                     organiser_id = '$this->organiser_id'
//                     created_at = '$this->date'
                WHERE
                    id = '$this->event_id'";
                
                return $this->conn->update($query);
            }
            return false;
        }
        
        public function delete()
        {
            if ('' != $this->event_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    id = '$this->event_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>