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
    $seminar->seminar_id        = htmlspecialchars(strip_tags($data->seminar_id));
    $seminar->name              = htmlspecialchars(strip_tags($data->name));
    $seminar->desc              = htmlspecialchars(strip_tags($data->desc));
    $seminar->address           = htmlspecialchars(strip_tags($data->address));
    $seminar->municipality      = htmlspecialchars(strip_tags($data->municipality));
    $seminar->province          = htmlspecialchars(strip_tags($data->province));
    $seminar->email             = htmlspecialchars(strip_tags($data->email));
    $seminar->mobile            = htmlspecialchars(strip_tags($data->mobile));
    $seminar->fixed             = htmlspecialchars(strip_tags($data->fixed));
    $seminar->days              = htmlspecialchars(strip_tags($data->days));
    $seminar->start             = htmlspecialchars(strip_tags($data->start));
    $seminar->attendees         = htmlspecialchars(strip_tags($data->attendees));
    $seminar->speakers          = htmlspecialchars(strip_tags($data->speakers));
    $seminar->exhibitors        = htmlspecialchars(strip_tags($data->exhibitors));
    $seminar->topic             = htmlspecialchars(strip_tags($data->topic));
    
    
    $result = $seminar->update();
    
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