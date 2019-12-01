<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/facilitated.php';
    include_once '../shared/status.php';
    
    // initialize object
    $learner = new Facilitated();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $learner->enroll_id         = htmlspecialchars(strip_tags($data->enroll_id));
//     $report->date              = htmlspecialchars(strip_tags($data->date));
    $learner->facilitator       = htmlspecialchars(strip_tags($data->facilitator));
    $learner->status            = htmlspecialchars(strip_tags($data->status));
    
    $result = $learner->update();
    
    // check if record is valid
    if(false != $result)
    {
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString("Record Successfully Updated"));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("Record Update Error");
        echo ($errMsg);
    }
    
    // no learners found 
?>