<?php
    include_once '../config/config.inc.php';
    include_once '../helpers/Format.php';
    include_once '../lib/Database.php';
    
    class QuestionInfo
    {
        // object properties
        public $id;
        public $question_id;                    // Unique system question identifier 
        public $exam_id;                        // Exam ID of exam questions is assigned to 
        public $author;                         // User who created the question
        public $type;                           // Question type ==> Multiple Choice, Short Answer, Long Answer, file upload
        public $question;                       // Question Text
        public $marks;                          // Question marks.
        public $answer1;                        // Question Answer 1 - Main answer in case of short, long questions
        public $answer2;                        // Question Answer 2 - used in case of multiple choice
        public $answer3;                        // Question Answer 3 - used in case of multiple choice
        public $answer4;                        // Question Answer 4 - used in case of multiple choice
        public $correct_answer1;                // Correct Answer
        public $time;                           // Maximum time learner should spend on question - In seconds
        public $date;                           // Date question was created
    }
    
    
    class Question extends QuestionInfo
    {
        // database connection and table name
        private $conn;
        private $table_name = DB_QUESTION_TBL;
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
        
        
        // Read Questions by Question ID
        public function readByQuestionId($questionId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE question_id='$questionId'";
            
            // execute query statement
            $stmt = $this->conn->select($query);
            
            return $stmt;
        }
        
        
        // Read Questions by Exam ID
        public function readByExamId($examId)
        {
            // select query
            $query = "SELECT * FROM " . $this->table_name . " WHERE exam_id='$examId'";
            
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
            if ('' != $this->question_id)
            {
                
                // update query
                $query = "INSERT INTO
                    " . $this->table_name . "
                (
                    question_id, 
                    exam_id, 
                    author, 
                    type, 
                    question, 
                    marks, 
                    answer1,
                    answer2,
                    answer3,
                    answer4,
                    correct_answer1,
                    date
                )
                VALUES
                (
                    '$this->question_id', 
                    '$this->exam_id', 
                    '$this->author', 
                    '$this->type', 
                    '$this->question', 
                    '$this->marks', 
                    '$this->answer1',
                    '$this->answer2',
                    '$this->answer3',
                    '$this->answer4',
                    '$this->correct_answer1',
                    '$this->date'
                )
                ON DUPLICATE KEY UPDATE
                    question_id = '$this->question_id',
                    exam_id = '$this->exam_id',
                    author = '$this->author',
                    type = '$this->type',
                    question = '$this->question',
                    marks = '$this->marks',
                    answer1 = '$this->answer1',
                    answer2 = '$this->answer2',
                    answer3 = '$this->answer3',
                    answer4 = '$this->answer4',
                    correct_answer1 = '$this->correct_answer1',
                    date = '$this->date'
                ";
                
                return $this->conn->insert($query);
            }
            
            return false;
        }
        
        
        public function update()
        {
            if ('' != $this->question_id)
            {
                
                // update query
                $query = "UPDATE
                    " . $this->table_name . "
                SET
                    author = '$this->author',
                    type = '$this->type',
                    question = '$this->question',
                    exam_id = '$this->exam_id',
                    marks = '$this->marks',
                    answer1 = '$this->answer1',
                    answer2 = '$this->answer2',
                    answer3 = '$this->answer3',
                    answer4 = '$this->answer4',
                    correct_answer1 = '$this->correct_answer1'
//                     date = '$this->date'
                WHERE
                    question_id = '$this->question_id'";
                
                return $this->conn->update($query);
                
            }
            
            return false;
        }
        
        
        public function delete()
        {
            if ('' != $this->question_id)
            {
                
                // delete query
                $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE
                    question_id = '$this->question_id'";
                
                return $this->conn->delete($query);
            }
            
            return false;
        }
    }
?>