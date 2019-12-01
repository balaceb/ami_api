<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/attendee.php';
    include_once '../shared/status.php';
    
    // initialize object
    $user = new Attendee();
    
    $result = false;
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Check action if it is a password change action
    $action            = htmlspecialchars(strip_tags($data->action));
    
    if("update_pwd" == $action)
    {
        $user->attendee_id  = htmlspecialchars(strip_tags($data->attendee_id));
        $user->password     = htmlspecialchars(strip_tags($data->password));
        $result             = $user->updatePwd();
    }
    else
    {
        // Read and sanitize update values
        $user->attendee_id       = htmlspecialchars(strip_tags($data->attendee_id));
    //     $report->date              = htmlspecialchars(strip_tags($data->date));
        $user->title             = htmlspecialchars(strip_tags($data->title));
        $user->fname             = htmlspecialchars(strip_tags($data->fname));
        $user->lname             = htmlspecialchars(strip_tags($data->lname));
        $user->username          = htmlspecialchars(strip_tags($data->username));
        $user->email             = htmlspecialchars(strip_tags($data->email));
        $user->dob               = htmlspecialchars(strip_tags($data->dob));
        $user->sex               = htmlspecialchars(strip_tags($data->sex));
        
        $user->idc_num           = htmlspecialchars(strip_tags($data->idc_num));
        
        $user->idc               = htmlspecialchars(strip_tags($data->idc));
        $user->cv                = htmlspecialchars(strip_tags($data->cv));
        $user->address           = htmlspecialchars(strip_tags($data->address));
        $user->municipality      = htmlspecialchars(strip_tags($data->municipality));
        $user->province          = htmlspecialchars(strip_tags($data->province));
        $user->fixed             = htmlspecialchars(strip_tags($data->tel));
        $user->mobile            = htmlspecialchars(strip_tags($data->cell));
        
        $user->status            = htmlspecialchars(strip_tags($data->status));
    
        
        $result = $user->update();
    }
    
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