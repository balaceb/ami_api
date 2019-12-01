<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/assessed.php';
    include_once '../shared/status.php';
    
    // initialize object
    $learner = new Assessed();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
//     $learner->enroll_id          = htmlspecialchars(strip_tags($data->enroll_id));
    $learner->assessed_id        = htmlspecialchars(strip_tags($data->assessed_id));
//     $learner->date               = htmlspecialchars(strip_tags($data->date));
    $learner->assessor           = htmlspecialchars(strip_tags($data->assessor));
    $learner->script             = htmlspecialchars(strip_tags($data->script));
    $learner->module             = htmlspecialchars(strip_tags($data->module));
    $learner->moderate           = htmlspecialchars(strip_tags($data->moderate));
    $learner->competence         = htmlspecialchars(strip_tags($data->competence));
    $learner->status             = htmlspecialchars(strip_tags($data->status));
    
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