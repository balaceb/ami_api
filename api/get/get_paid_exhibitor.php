<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/PaidExhibitor.php';
    include_once '../shared/status.php';
    
    // initialize object
    $payment = new PaidExhibitor();
    
    // query sponsors
    // Read all if ID is not SET otherwise read only affected record(s)
    $result = isset($_GET['seminar']) ? $payment->readBySeminarId($_GET['seminar']) : false;                 // Read by seminar ID
    if (false == $result) {
        $result = isset($_GET['user']) ? $payment->readByUserId($_GET['user']) : $payment->readAll();   // read by user's registration ID
        
        if (false == $result) {
            $result = isset($_GET['payment']) ? $payment->readByPaymentId($_GET['payment']) : $payment->readAll();   // read by Payment ID
        }
    }
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $payment_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result)){
            // extract row
            // this will make $row['name'] to
            // just $name only
           // extract($row);
            
            $paymentInfo = new PaidExhibitorInfo();
            
            $paymentInfo->id         = $row['id'];
            $paymentInfo->ticket_id  = $row['ticket_id'];
            $paymentInfo->seminar_id = $row['seminar_id'];
            $paymentInfo->user_id    = $row['user_id'];
            $paymentInfo->name       = $row['name'];
            $paymentInfo->amount     = $row['amount'];
            $paymentInfo->reference  = $row['reference'];
            $paymentInfo->date       = $row['date'];
            
            $payment_arr[$cntr] = $paymentInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($payment_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>