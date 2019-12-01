<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/ExhibitionTicket.php';
    include_once '../shared/status.php';
    
    // initialize object
    $ticket = new ExhibitionTicket();
    
    $result = false;
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $ticket->ticket_id      = htmlspecialchars(strip_tags($data->ticket_id));
    $ticket->seminar_id     = htmlspecialchars(strip_tags($data->seminar_id));
    $ticket->name           = htmlspecialchars(strip_tags($data->name));
//     $report->date              = htmlspecialchars(strip_tags($data->date));
    $ticket->isDesc         = htmlspecialchars(strip_tags($data->isDesc));
    $ticket->desc           = htmlspecialchars(strip_tags($data->desc));
    $ticket->amount         = htmlspecialchars(strip_tags($data->amount));
    $ticket->status         = htmlspecialchars(strip_tags($data->status));
    
    $result = $ticket->update();
    
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