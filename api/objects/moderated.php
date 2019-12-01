<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    
    // Internal moderation info
    class InModeratedInfo
    {
        
        // object properties
        public $id;
        public $enroll_id;                      // Unique system identifier to map learners to users. This ID is unique for each programme a learner enrolls for
        public $moderated_id;                   // Unique moderated script ID
        public $moderator;                      // Moderator's name
        public $date;                           // Moderation date
        public $script;                         // Moderated Script filename+locaiton on server
        public $module;                         // Moderated Script type - E.g Formative Module 1, Summative Module 2
        public $competence;                     // Competent/Not Competent
    }
    
    
    // External moderation info
    class ExModeratedInfo
    {
        
        // object properties
        public $id;
        public $enroll_id;                      // Unique system identifier to map learners to users. This ID is unique for each programme a learner enrolls for
        public $moderator;                      // Moderator's name
        public $date;                           // Moderation date
    }
    
    
    // Class for external moderation
    class ExModerated extends ExModeratedInfo
    {
        
        // database connection and table name
        private $conn;
        private $table_name = DB_EXT_MODERATED_TBL;
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
        
        
        // Read learners by their Registration ID
        public function readByRegId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE reg_id='$regId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their Enroll ID
        public function readByEnrollId($enrollId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE enroll_id='$enrollId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their primary unique key
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
            if ('' != $this->enroll_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    enroll_id,
                    enroll_id,
                    moderator,
                    date
                )
                VALUES
                (
                    '$this->enroll_id',
                    '$this->moderator',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    moderator = '$this->moderator',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->enroll_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    moderator = '$this->moderator'
//                     date = '$this->date'
                WHERE
                    enroll_id = '$this->enroll_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->enroll_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    enroll_id = '$this->enroll_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
        
        
    }
    
    
    
    // Class for internal moderation
    class InModerated extends InModeratedInfo
    {
     
        // database connection and table name
        private $conn;
        private $table_name = DB_INT_MODERATED_TBL;
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
        
        
        // Read learners by their Registration ID
        public function readByRegId($regId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE reg_id='$regId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by Moderated script ID
        public function readByModeratedId($moderatedId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE moderated_id='$moderatedId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their Enroll ID
        public function readByEnrollId($enrollId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE enroll_id='$enrollId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read learners by their primary unique key
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
            if ('' != $this->enroll_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    enroll_id,
                    moderated_id,
                    competence,
                    module,
                    script,
                    moderator,
                    date
                )
                VALUES
                (
                    '$this->enroll_id',
                    '$this->moderated_id',
                    '$this->competence',
                    '$this->module',
                    '$this->script',
                    '$this->moderator',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    enroll_id = '$this->enroll_id',
                    competence = '$this->competence',
                    module = '$this->module',
                    script = '$this->script',
                    moderator = '$this->moderator',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->moderated_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    competence = '$this->competence',
                    module = '$this->module',
                    script = '$this->script',
                    moderator = '$this->moderator'
//                     date = '$this->date'
                WHERE
                    moderated_id = '$this->moderated_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->moderated_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    moderated_id = '$this->moderated_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>