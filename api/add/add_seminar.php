<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/seminar.php';
    include_once '../shared/status.php';
    
    // initialize object
    $seminar = new Seminar();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $seminar->email             = htmlspecialchars(strip_tags($data->email));
    $seminar->seminar_id        = md5((string)time()); // htmlspecialchars(strip_tags($data->seminar_id));
    $seminar->address           = htmlspecialchars(strip_tags($data->address));
    $seminar->attendees         = htmlspecialchars(strip_tags($data->attendees));
    $seminar->days              = htmlspecialchars(strip_tags($data->days));
    $seminar->desc              = htmlspecialchars(strip_tags($data->desc));
    $seminar->email             = htmlspecialchars(strip_tags($data->email));
    $seminar->exhibitors        = htmlspecialchars(strip_tags($data->exhibitors));
    $seminar->fixed             = htmlspecialchars(strip_tags($data->fixed));
    $seminar->mobile            = htmlspecialchars(strip_tags($data->mobile));
    $seminar->municipality      = htmlspecialchars(strip_tags($data->municipality));
    $seminar->name              = htmlspecialchars(strip_tags($data->name));
    $seminar->province          = htmlspecialchars(strip_tags($data->province));
    $seminar->speakers          = htmlspecialchars(strip_tags($data->speakers));
    $seminar->start             = htmlspecialchars(strip_tags($data->start));
    $seminar->topic             = htmlspecialchars(strip_tags($data->topic));
    $seminar->date              = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    
    $result = $seminar->add();
    
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