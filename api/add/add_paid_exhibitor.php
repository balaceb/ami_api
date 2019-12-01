<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/PaidExhibitor.php';
    include_once '../shared/status.php';
    
    // initialize object
    $payment = new PaidExhibitor();
    
    // get data of item to be added
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $payment->payment_id     = md5((string)time()); // htmlspecialchars(strip_tags($data->ticket_id));
    $payment->date           = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    $payment->seminar_id     = htmlspecialchars(strip_tags($data->seminar_id));
    $payment->user_id        = htmlspecialchars(strip_tags($data->user_id));
    $payment->name           = htmlspecialchars(strip_tags($data->name));
    $payment->reference      = htmlspecialchars(strip_tags($data->reference));
    $payment->amount         = htmlspecialchars(strip_tags($data->amount));
    
    $result = $payment->add();
    
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