<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/question.php';
    include_once '../shared/status.php';
    
    // initialize object
    $question = new Question();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $question->question_id      = md5((string)time()); // htmlspecialchars(strip_tags($data->question_id));
    $question->author           = htmlspecialchars(strip_tags($data->author));
    $question->question         = htmlspecialchars(strip_tags($data->question));
    $question->type             = htmlspecialchars(strip_tags($data->type));
    $question->answer1          = htmlspecialchars(strip_tags($data->answer1));
    $question->answer2          = htmlspecialchars(strip_tags($data->answer2));
    $question->answer3          = htmlspecialchars(strip_tags($data->answer3));
    $question->answer4          = htmlspecialchars(strip_tags($data->answer4));
    $question->correct_answer1  = htmlspecialchars(strip_tags($data->correct_answer1));
    $question->date             = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    
    $result = $question->add();
    
    // check if record is valid
    if(false != $result)
    {
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString("Record Successfully Added"));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("Record Add Error");
        echo ($errMsg);
    }
    
    // no learners found 
?>