<?php
    // When learners enroll after registration, they are stored in this table.
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/exam.php';
    include_once '../shared/status.php';
    
    // initialize object
    $exam = new Exams();
    
    // query question
    // Read all if Exam ID is not SET otherwise read only records that match ID/Exam ID
    $result = isset($_GET['id']) ? $exam->readByExamId($_GET['id']) : $exam->readAll();
    
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $exam_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result))
        {
            
            $examInfo                       = new ExamInfo();
            
            $examInfo->id                   = $row['id'];                       // id ==> DB unique primary key

            $examInfo->exam_id              = $row['exam_id'];
            $examInfo->author               = $row['author'];
            $examInfo->title                = $row['title'];
            $examInfo->start                = $row['start'];
            $examInfo->end                  = $row['end'];                 
            
            $examInfo->date                 = $row['date'];

            $exam_arr[$cntr] = $examInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($exam_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>