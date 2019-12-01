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
    $user = new Sponsorship();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $user->sponsorship_id        = md5((string)time()); // htmlspecialchars(strip_tags($data->reg_id));
    $user->date              = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    $user->sponsor_id             = htmlspecialchars(strip_tags($data->sponsor_id));
    $user->agreement             = htmlspecialchars(strip_tags($data->fname));
    $user->amount             = htmlspecialchars(strip_tags($data->lname));
    $user->receipt          = htmlspecialchars(strip_tags($data->username));
    $user->status            = htmlspecialchars(strip_tags($data->status));
    
    $result = $user->add();
    
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