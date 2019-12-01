<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class UserDocumentInfo
    {
        // object properties
        public $id;
        public $doc_id;
        public $seminar_id;         // Seminar document is related to for docs like feedback form. For CVs and IDs, this will be blank
        public $user_id;            // user's unique ID. User who uploaded document or document owner
        public $type;               // Type or category of document. E.g CV, ID, feedback form
        public $doc;                // Document link on server
        public $desc;               // Brief Document description
        public $date;               // Date document was uploaded
    }
    
    class UserDocument extends UserDocumentInfo{
     
        // database connection and table name
        private $conn;
        private $table_name = DB_USER_DOC_TBL;
        private $fmt;
        
        
        // constructor with $db as database connection
        public function __construct(){
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
        
        
        // Read Document by Document ID
        public function readByDocumentId($docId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE doc_id='$docId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Document by unique Key / ID
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
            if ('' != $this->doc_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    doc_id,
                    seminar_id,
                    user_id,
                    type,
                    doc,
                    desc,
                    date
                )
                VALUES
                (
                    '$this->doc_id',
                    '$this->seminar_id',
                    '$this->user_id',
                    '$this->type',
                    '$this->doc',
                    '$this->desc',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    doc_id = '$this->doc_id',
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    type = '$this->type',
                    doc = '$this->doc',
                    desc = '$this->desc',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->doc_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    seminar_id = '$this->seminar_id',
                    user_id = '$this->user_id',
                    type = '$this->type',
                    doc = '$this->doc',
                    desc = '$this->desc'
                WHERE
                    doc_id = '$this->doc_id'";
                
                return $this->conn->update($query);
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->doc_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    doc_id = '$this->doc_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>