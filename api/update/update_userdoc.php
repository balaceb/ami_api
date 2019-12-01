<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/userdoc.php';
    include_once '../shared/status.php';
    
    // initialize object
    $doc = new UserDocument();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $doc->user_id        = htmlspecialchars(strip_tags($data->user_id));
    $doc->seminar_id     = htmlspecialchars(strip_tags($data->seminar_id));
    $doc->doc_id         = htmlspecialchars(strip_tags($data->doc_id));
    $doc->doc            = htmlspecialchars(strip_tags($data->doc));
    $doc->desc           = htmlspecialchars(strip_tags($data->desc));
    $doc->type           = htmlspecialchars(strip_tags($data->type));
    
    $result = $doc->update();
    
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
    
    // no record found 
?>