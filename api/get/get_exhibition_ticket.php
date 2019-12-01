<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/ExhibitionTicket.php';
    include_once '../shared/status.php';
    
    // initialize object
    $ticket = new ExhibitionTicket();
    
    // query sponsors
    // Read all if ID is not SET otherwise read only affected record(s)
    $result = isset($_GET['seminar']) ? $ticket->readBySeminarId($_GET['seminar']) : false;                 // Read by seminar ID
    if (false == $result) {
        $result = isset($_GET['ticket']) ? $ticket->readByTicketId($_GET['ticket']) : $ticket->readAll();   // read by ticket ID
    }
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $ticket_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result)){
            // extract row
            // this will make $row['name'] to
            // just $name only
           // extract($row);
            
            $ticketInfo = new ExhibitionTicketInfo();
            
            $ticketInfo->id         = $row['id'];
            $ticketInfo->ticket_id  = $row['ticket_id'];
            $ticketInfo->seminar_id = $row['seminar_id'];
            $ticketInfo->name       = $row['name'];
            $ticketInfo->desc       = $row['desc'];
            $ticketInfo->isDesc     = $row['isDesc'];
            
            $ticketInfo->date       = $row['date'];
            
            $ticketInfo->status     = $row['status'];
            
            
            $ticket_arr[$cntr] = $ticketInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($ticket_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>