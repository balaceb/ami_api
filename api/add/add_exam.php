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
    $exam = new Exams();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $exam->exam_id      = md5((string)time()); // htmlspecialchars(strip_tags($data->question_id));
    $exam->author       = htmlspecialchars(strip_tags($data->author));
    $exam->start        = htmlspecialchars(strip_tags($data->answer1));
    $exam->end          = htmlspecialchars(strip_tags($data->answer2));
    $exam->title        = htmlspecialchars(strip_tags($data->answer4));
    $exam->date         = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    
    $result = $exam->add();
    
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