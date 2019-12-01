<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/assessed.php';
    include_once '../shared/status.php';
    
    // initialize object
    $learner = new Assessed();
    
    // query learners
    // Read all if Enrollment ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $learner->readByEnrollId($_GET['id']) : $learner->readAll();
    
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $question_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result))
        {
            
            $learnerInfo                        = new AssessedInfo();
            
            $learnerInfo->id                    = $row['id'];                       // id ==> DB primary key

            $learnerInfo->enroll_id             = $row['enroll_id'];
            $learnerInfo->assessed_id           = $row['assessed_id'];
            $learnerInfo->assessor              = $row['assessor'];                 // Assessor's name
            
            $learnerInfo->date                  = $row['date'];

            $learnerInfo->module                = $row['module'];                   // assessed module
            $learnerInfo->script                = $row['script'];                   // assessed script
            $learnerInfo->moderate              = $row['moderate'];                 // If learner should be moderated
            $learnerInfo->competence            = $row['competence'];               // Competent/not Competent
            $learnerInfo->status                = $row['status'];                   // 0 ==> learner has NOT been facilitated
            
            $question_arr[$cntr] = $learnerInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($question_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>