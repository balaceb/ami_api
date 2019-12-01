<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/appeals.php';
    include_once '../shared/status.php';
    
    // initialize object
    $appeal = new Appeals();
    
    // query learners
    // Read all if Enrollment ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $appeal->readByEnrollId($_GET['id']) : $appeal->readAll();
    
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $learner_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result))
        {
            
            $learnerInfo                        = new AppealInfo();
            
            $learnerInfo->id                    = $row['id'];                       // id ==> DB unique primary key
            $learnerInfo->enroll_id             = $row['enroll_id'];
            
            $learnerInfo->complaint_id          = $row['complaint_id'];
            $learnerInfo->complaint             = $row['complaint'];
            
            $learnerInfo->assessor              = $row['assessor'];                 // Assessor's name
            $learnerInfo->module                = $row['module'];                   // assessed module being appealed
            $learnerInfo->script                = $row['script'];                   // assessed script being appealed
            
            $learnerInfo->reason                = $row['reason'];                   // Assessor's reason for assessment outcome
            $learnerInfo->decision              = $row['decision'];                 // Moderator's verdict/conclusion on learner's appeal request
            
            $learnerInfo->status                = $row['status'];                   // Appeal status
            $learnerInfo->date                  = $row['date'];
            
            $learner_arr[$cntr] = $learnerInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($learner_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>