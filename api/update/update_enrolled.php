<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/enrolled.php';
    include_once '../shared/status.php';
    
    // initialize object
    $enrolled = new Enrolled();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $enrolled->enroll_id        = htmlspecialchars(strip_tags($data->enroll_id));
//     $report->enroll_date      = htmlspecialchars(strip_tags($data->enroll_date));
    $enrolled->enroll_letter    = htmlspecialchars(strip_tags($data->enroll_letter));
    $enrolled->session_id       = htmlspecialchars(strip_tags($data->session_id));
    $enrolled->reg_id           = htmlspecialchars(strip_tags($data->reg_id));
    $enrolled->status           = htmlspecialchars(strip_tags($data->status));
    
    $result = $enrolled->update();
    
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