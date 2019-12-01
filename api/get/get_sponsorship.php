<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/sponsorship.php';
    include_once '../shared/status.php';
    
    // initialize object
    $sponsorship = new Sponsorship();
    
    // query sponsors
    // Read all if Registration ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $sponsorship->readBySonsorshipId($_GET['id']) : $sponsorship->readAll();
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $sponsorship_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result)){
            // extract row
            // this will make $row['name'] to
            // just $name only
           // extract($row);
            
            $sponsorshipInfo = new SponsorshipInfo();
            
            $sponsorshipInfo->id    = $row['id'];
            $sponsorshipInfo->sponsorship_id= $row['sponsorship_id'];
            $sponsorshipInfo->sponsor_id= $row['sponsor_id'];
            $sponsorshipInfo->agreement= $row['agreement'];
            $sponsorshipInfo->amount = $row['amount'];
            $sponsorshipInfo->receipt = $row['receipt'];

            $sponsorshipInfo->date = $row['date'];
            
            $sponsorshipInfo->status = $row['status'];
            
            $sponsorship_arr[$cntr] = $sponsorshipInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show data in json format
        echo (GetJsonStatusMsg::getJsonString($sponsorship_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>