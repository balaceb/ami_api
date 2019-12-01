<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/seminar.php';
    include_once '../shared/status.php';
    
    // initialize object
    $seminar = new Seminar();
    
    // query learners
    // Read all if Registration ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $seminar->readBySeminarId($_GET['id']) : $seminar->readAll();
    
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $seminar_arr=array();
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
            
            $seminarInfo = new SeminarInfo();
            
            $seminarInfo->id                = $row['id'];               // id ==> DB primary key

            $seminarInfo->seminar_id        = $row['seminar_id'];
            $seminarInfo->name              = $row['name'];
            
            $seminarInfo->date              = $row['date'];
            $seminarInfo->desc              = $row['desc'];
            $seminarInfo->address           = $row['address'];
            $seminarInfo->municipality      = $row['municipality'];
            $seminarInfo->province          = $row['province'];
            $seminarInfo->email             = $row['email'];
            $seminarInfo->mobile            = $row['mobile'];
            $seminarInfo->fixed             = $row['fixed'];
            $seminarInfo->days              = $row['days'];
            $seminarInfo->start             = $row['start'];
            $seminarInfo->attendees         = $row['attendees'];
            $seminarInfo->speakers          = $row['speakers'];
            $seminarInfo->exhibitors        = $row['exhibitors'];
            $seminarInfo->topic             = $row['topic'];
            
            $seminar_arr[$cntr] = $seminarInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($seminar_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>