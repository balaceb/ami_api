<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/appeals.php';
    include_once '../shared/status.php';
    
    // initialize object
    $appeal = new Appeals();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $appeal->enroll_id          = htmlspecialchars(strip_tags($data->enroll_id));
    $appeal->assessor           = htmlspecialchars(strip_tags($data->assessor));
    $appeal->script             = htmlspecialchars(strip_tags($data->script));
    $appeal->module             = htmlspecialchars(strip_tags($data->module));
    $appeal->complaint          = htmlspecialchars(strip_tags($data->complaint));
    $appeal->complaint_id       = md5((string)time()); // htmlspecialchars(strip_tags($data->complaint_id));
    $appeal->reason             = htmlspecialchars(strip_tags($data->reason));
    $appeal->decision           = htmlspecialchars(strip_tags($data->decision));
    $appeal->date               = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    $appeal->status             = htmlspecialchars(strip_tags($data->status));
    
    $result = $appeal->add();
    
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