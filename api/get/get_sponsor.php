<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include object files
    include_once '../objects/sponsor.php';
    include_once '../shared/status.php';
    
    // initialize object
    $user = new Sponsor();
    
    // query sponsors
    // Read all if Registration ID is not SET otherwise read only one record
    $result = isset($_GET['id']) ? $user->readBySponsorId($_GET['id']) : $user->readAll();
    
    // check if record is valid
    if(false != $result)
    {
        
        // products array
        $user_arr=array();
        $cntr = 0;
        
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = mysqli_fetch_assoc($result)){
            // extract row
            // this will make $row['name'] to
            // just $name only
           // extract($row);
            
            $userInfo = new SponsorInfo();
            
            $userInfo->id    = $row['id'];
            $userInfo->sponsor_id= $row['sponsor_id'];
            $userInfo->title= $row['title'];
            $userInfo->fname = $row['fname'];
            $userInfo->lname = $row['lname'];
            $userInfo->email = $row['email'];
            $userInfo->username = $row['username'];
            $userInfo->sex = $row['sex'];
            $userInfo->idc_num = $row['idc_num'];
            $userInfo->password = $row['password'];
            $userInfo->dob = $row['dob'];
            
            $userInfo->idc = $row['idc'];
            $userInfo->cv = $row['cv'];
            
            $userInfo->address = $row['address'];
            $userInfo->municipality = $row['municipality'];
            $userInfo->province = $row['province'];

            $userInfo->fixed = $row['fixed'];
            $userInfo->mobile = $row['mobile'];
            
            $userInfo->date = $row['date'];
            
            $userInfo->status = $row['status'];
            
            
            $user_arr[$cntr] = $userInfo;
            $cntr++;
        }
        
        // set response code - 200 OK
        http_response_code(200);
        
        // show learner data in json format
        echo (GetJsonStatusMsg::getJsonString($user_arr));
    }
    else 
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
    // no learners found 
?>