<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/achieved.php';
    include_once '../shared/status.php';
    
    // initialize object
    $learner = new Achieved();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $learner->enroll_id         = htmlspecialchars(strip_tags($data->enroll_id));
    $learner->achieved_id       = md5((string)time()); // htmlspecialchars(strip_tags($data->achieved_id));
    $learner->achieved_letter   = htmlspecialchars(strip_tags($data->achieved_letter));
    $learner->certificate       = htmlspecialchars(strip_tags($data->certificate));
    $learner->date              = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    
    $result = $learner->add();
    
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