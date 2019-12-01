<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/reports.php';
    include_once '../shared/status.php';
    
    // initialize object
    $report = new Reports();
    
    // query doc
    // Read all if enroll ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $report->readByEnrollId($_GET['id']) : $report->readAllUsers();
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $doc_arr=array();
        $cntr = 0;
        
        while ($row = mysqli_fetch_assoc($result)){
            
            $reportInfo = new ReportInfo();
            
            $reportInfo->id        = $row['id'];
            $reportInfo->enroll_id = $row['enroll_id'];
            $reportInfo->report_id = $row['report_id'];
            $reportInfo->report    = $row['report'];
            $reportInfo->reporter  = $row['reporter'];
            $reportInfo->type      = $row['type'];
            $reportInfo->date      = $row['date'];
            
            $doc_arr[$cntr]    = $reportInfo;
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