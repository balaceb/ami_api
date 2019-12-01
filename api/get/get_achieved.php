<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/achieved.php';
    include_once '../shared/status.php';
    
    // initialize object
    $learner = new Achieved();
    
    // query learners
    // Read all if Registration ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $learner->readByEnrollId($_GET['id']) : $learner->readAll();
    
    
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
//            extract($row);
            
            $learnerInfo = new AchievedInfo();
            
            $learnerInfo->id                = $row['id'];               // id ==> DB primary key

            $learnerInfo->enroll_id         = $row['enroll_id'];
            $learnerInfo->achieved_id       = $row['achieved_id'];
            
            $learnerInfo->date              = $row['date'];
            $learnerInfo->achieved_letter   = $row['achieved_letter'];
            $learnerInfo->certificate       = $row['certificate'];
            
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