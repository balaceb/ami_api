<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class ExamInfo
    {
        // object properties
        public $id;
        public $exam_id;                    
        public $title;                          // Exam Title/Name
        public $author;                         // Total Marks required for pass
        public $start;                          // When exam is to be taken. Exam can not be started before this date
        public $end;                            // When exam is to end. Exam can not be started after this date
        public $date;                           // Date exam was created
    }
    
    
    class Exams extends ExamInfo
    {
        // database connection and table name
        private $conn;
        private $table_name = DB_EXAMS_TBL;
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
        
        
        // Read Exam by Exam ID
        public function readByExamId($questionId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE question_id='$questionId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read questions by their primary unique key
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
            if ('' != $this->exam_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    exam_id, 
                    title, 
                    author, 
                    start,
                    end,
                    date
                )
                VALUES
                (
                    '$this->exam_id', 
                    '$this->title', 
                    '$this->author', 
                    '$this->start',
                    '$this->end',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
//                     exam_id = '$this->exam_id',
                    title = '$this->title',
                    author = '$this->author',
                    start = '$this->start',
                    end = '$this->end',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->exam_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    author = '$this->author',
                    title = '$this->title',
                    author = '$this->author',
                    start = '$this->start',
                    end = '$this->end'
//                     date = '$this->date'
                WHERE
                    exam_id = '$this->exam_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->exam_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    exam_id = '$this->exam_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>