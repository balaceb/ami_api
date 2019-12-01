<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include object files
    include_once '../objects/speaker.php';
    include_once '../shared/status.php';
    
    // initialize object
    $user = new Speaker();
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // Read and sanitize update values
    $user->speaker_id        = md5((string)time()); // htmlspecialchars(strip_tags($data->reg_id));
    $user->date              = date('d-m-Y'); // htmlspecialchars(strip_tags($data->date));
    $user->title             = htmlspecialchars(strip_tags($data->title));
    $user->fname             = htmlspecialchars(strip_tags($data->fname));
    $user->lname             = htmlspecialchars(strip_tags($data->lname));
    $user->username          = htmlspecialchars(strip_tags($data->username));
    $user->dob               = htmlspecialchars(strip_tags($data->dob));
    $user->sex               = htmlspecialchars(strip_tags($data->sex));
    $user->password          = (htmlspecialchars(strip_tags($data->password)));     // Passwords will be hashed by application using this API
    $user->idc_num           = htmlspecialchars(strip_tags($data->idc_num));
    
    $user->idc               = htmlspecialchars(strip_tags($data->idc));            // Will contain doc_id of corresponding doc on docs table
    $user->cv                = htmlspecialchars(strip_tags($data->cv));             // Will contain doc_id of corresponding doc on docs table
    $user->pic               = htmlspecialchars(strip_tags($data->pic));            // Speaker's profile picture
    $user->address           = htmlspecialchars(strip_tags($data->address));
    $user->municipality      = htmlspecialchars(strip_tags($data->municipality));
    $user->province          = htmlspecialchars(strip_tags($data->province));
    $user->fixed             = htmlspecialchars(strip_tags($data->fixed));
    $user->mobile            = htmlspecialchars(strip_tags($data->mobile));
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