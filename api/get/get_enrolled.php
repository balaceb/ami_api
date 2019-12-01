<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/enrolled.php';
    include_once '../shared/status.php';
    
    // initialize object
    $enrolled = new Enrolled();
    
    // query learners
    // Read all if Registration ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $enrolled->readByEnrollId($_GET['id']) : $enrolled->readAll();
    
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
            // extract row
            // this will make $row['name'] to
            // just $name only
           // extract($row);
            
            $learnerInfo = new EnrolledInfo();
            
            $learnerInfo->id               = $row['id'];            // id ==> DB primary key
            $learnerInfo->status           = $row['status'];

            $learnerInfo->reg_id           = $row['reg_id'];
            $learnerInfo->session_id       = $row['session_id'];
            
            $learnerInfo->enroll_id        = $row['enroll_id'];
            $learnerInfo->enroll_date      = $row['enroll_date'];
            $learnerInfo->enroll_letter    = $row['enroll_letter'];
            
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