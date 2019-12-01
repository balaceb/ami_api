<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/attendance.php';
    include_once '../shared/status.php';
    
    // initialize object
    $register = new Attendance();
    
    // query register
    // Read all if enroll ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $register->readByAttendanceId($_GET['id']) : $register->readAll();
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $register_arr=array();
        $cntr = 0;
        
        while ($row = mysqli_fetch_assoc($result)){
            
            $registerInfo = new AttendanceInfo();
            
            $registerInfo->id               = $row['id'];
            $registerInfo->user_id          = $row['user_id'];
            $registerInfo->seminar_id       = $row['seminar_id'];
            $registerInfo->attendance_id    = $row['attendance_id'];
            $registerInfo->attendance_date  = $row['attendance_date'];
            $registerInfo->date             = $row['date'];
            
            $register_arr[$cntr]    = $registerInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($register_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no register found 
?>