<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/AttendizeIvpEvent.php';
    include_once '../shared/status.php';
    
    // initialize object
    $event = new AttendizeIvpEvent();
    
    $result = isset($_GET['id']) ? $event->readById($_GET['id']) : (isset($_GET['oid']) ? $event->readByOrganiserId($_GET['oid']) : $event->readAll());                 // Read by organiser ID
    
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
            
            $eventInfo = new AttendizeIvpEventInfo();
            
            $eventInfo->event_id        = $row['id'];
            $eventInfo->event_title     = $row['title'];
            $eventInfo->event_desc      = $row['description'];
            $eventInfo->event_details   = $row['details'];      // Details contains the cover video link, list of Ticket items
            $eventInfo->event_img       = $row['bg_image_path'];
            $eventInfo->event_start     = date("F jS, Y", strtotime($row['start_date']));
            $eventInfo->event_end       = date("F jS, Y", strtotime($row['end_date']));
            $eventInfo->event_venue     = $row['venue_name'];
            $eventInfo->event_city      = $row['location_state'];
            $eventInfo->event_addr1     = $row['location_address_line_1'];
            $eventInfo->event_addr2     = $row['location_address_line_2'];
            $eventInfo->event_postcode  = $row['location_post_code'];
            $eventInfo->event_author_id = $row['user_id'];
            $eventInfo->organiser_id    = $row['organiser_id'];
            $eventInfo->isEventDisabled = !$row['is_live'];
            
            // We calculate difference between now and end date of event. If now is bigger that event end date, then event ended.
            $delta_time = strtotime($row['end_date']) - time();
            
            $eventInfo->isEventExpired = (($delta_time<0)? 1 : 0);
            
            $eventInfo->date            = $row['created_at'];
            
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