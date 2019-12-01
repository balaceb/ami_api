<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/question.php';
    include_once '../shared/status.php';
    
    // initialize object
    $question = new Question();
    
    // query question
    // Read all if Question ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $question->readByExamId($_GET['id']) : $question->readAll();
    
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $question_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result))
        {
            
            $questionInfo                       = new QuestionInfo();
            
            $questionInfo->id                   = $row['id'];                       // id ==> DB unique primary key

            $questionInfo->question_id          = $row['question_id'];
            $questionInfo->question             = $row['question'];
            $questionInfo->exam_id              = $row['exam_id'];
            $questionInfo->marks                = $row['marks'];
            $questionInfo->answer1              = $row['answer1'];                 
            $questionInfo->answer2              = $row['answer2'];                 
            $questionInfo->answer3              = $row['answer3'];                 
            $questionInfo->answer4              = $row['answer4'];                 
            
            $questionInfo->date                 = $row['date'];

            $questionInfo->correct_answer1      = $row['correct_answer1'];                   
            $questionInfo->author               = $row['author'];                   
            $questionInfo->type                 = $row['type'];                 
            
            $question_arr[$cntr]                = $questionInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($question_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>