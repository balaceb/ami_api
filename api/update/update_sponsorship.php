<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/sponsorship.php';
    include_once '../shared/status.php';
    
    // initialize object
    $sponsorship = new Sponsorship();
    
    $result = false;
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $sponsorship->sponsorship_id    = htmlspecialchars(strip_tags($data->sponsorship_id));
    $sponsorship->sponsor_id        = htmlspecialchars(strip_tags($data->sponsor_id));
//     $report->date              = htmlspecialchars(strip_tags($data->date));
    $sponsorship->receipt           = htmlspecialchars(strip_tags($data->receipt));
    $sponsorship->agreement         = htmlspecialchars(strip_tags($data->agreement));
    $sponsorship->amount            = htmlspecialchars(strip_tags($data->amount));
    $sponsorship->status            = htmlspecialchars(strip_tags($data->status));
    
    $result = $sponsorship->update();
    
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