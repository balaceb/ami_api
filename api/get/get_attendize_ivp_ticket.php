<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/AttendizeIvpTicket.php';
    include_once '../shared/status.php';
    
    // initialize object
    $event = new AttendizeIvpTicket();
    
    $result = isset($_GET['id']) ? $event->readById($_GET['id']) : (isset($_GET['eid']) ? $event->readByEventId($_GET['eid']) : $event->readAll());                 // Read by organiser ID
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $events_arr=array();
        $cntr = 0;
        
        // retrieve our table content
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            // extract($row);
            
            $eventInfo = new AttendizeIvpTicketInfo();
            
            $eventInfo->ticket_id           = $row['id'];
            $eventInfo->ticket_title        = $row['title'];
            $eventInfo->ticket_cost         = $row['price'];
            $eventInfo->ticket_count        = $row['quantity_available'];
            $eventInfo->ticket_sale_start   = date("F jS, Y", strtotime($row['start_sale_date']));
            $eventInfo->ticket_sale_end     = date("F jS, Y", strtotime($row['end_sale_date']));
            $eventInfo->ticket_sold         = $row['quantity_sold'];
            $eventInfo->ticket_desc         = $row['description'];
            $eventInfo->ticket_event_id     = $row['event_id'];
            $eventInfo->date                = $row['created_at'];
            
            $events_arr[$cntr] = $eventInfo;
            $cntr++;
        }
        
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($events_arr));
    }
    else
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
?>