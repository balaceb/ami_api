<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/userdoc.php';
    include_once '../shared/status.php';
    
    // initialize object
    $doc = new UserDocument();
    
    // query doc
    // Read all if enroll ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $doc->readByDocumentId($_GET['id']) : $doc->readAll();
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $doc_arr=array();
        $cntr = 0;
        
        while ($row = mysqli_fetch_assoc($result)){
            
            $docInfo = new UserDocumentInfo();
            
            $docInfo->id        = $row['id'];
            $docInfo->doc_id    = $row['doc_id'];
            $docInfo->seminar_id= $row['seminar_id'];
            $docInfo->user_id   = $row['user_id'];
            $docInfo->doc       = $row['doc'];
            $docInfo->type      = $row['type'];
            $docInfo->date      = $row['date'];
            
            $doc_arr[$cntr]    = $docInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($doc_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no doc found 
?>