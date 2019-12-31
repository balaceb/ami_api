<?php
/*
 * This file handles post requests (from events website) to get Past IVP Gallery and IVP Venue Gallery.
 * 
 */
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include lib files
    include_once '../shared/status.php';
    
    // ToDo: Please change accordingly
//     $domain = "api.com/";
    $domain = "http://localhost/aser/others/learning/test_api/";
    
    class AttendizeEventsImages
    {
        
        // object properties
        public $name;               // Image filename
        public $url;                // Image full path
        public $type;               // Image type. Is it ivp, church, etc
    }
    
    
    /**
     * Check if a directory is empty (a directory with just '.svn' or '.git' is empty)
     *
     * @param string $dirname
     * @return bool
     */
    function dir_is_empty($dirname)
    {
        if (!is_dir($dirname)) return false;
        foreach (scandir($dirname) as $file)
        {
            if (!in_array($file, array('.','..','.svn','.git'))) return false;
        }
        return true;
    }
    
    /**
     * Get all Items in the given directory and return as an array
     *
     * @param string $dirname
     * @return []: Array of directory elements
     */
    function dirToArray($dir) {
        
        $result = array();
        
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value)
        {
            $key;
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    // This is a subdirectory. It is added as an array in the main array. This should not apply for now in our case
                    $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    $result[] = $value;
                }
            }
        }
        
        return $result;
    }
    
    // main array
    $images_arr=array();
    $cntr = 0;
    
    $requestId = isset($_GET['id']) ? $_GET['id'] : false;                 // Read id to know type of image to read
    
    // check if record is valid
    if(false != $requestId)
    {
        $images_folder = "";
        $url_images_folder = "";
        $type = "";
        
        switch($requestId)
        {
            case "gallery":     // IVP pictures for the slider (at the bottom)
                $images_folder = "../data/images/IVP/" . strtoupper($requestId);
                $url_images_folder = $domain . "api/data/images/IVP/" . strtoupper($requestId);
                $type = "ivp";
                break;

            case "venue":  // ivp venue pics
                $images_folder = "../data/images/IVP/" . strtoupper($requestId);
                $url_images_folder = $domain . "api/data/images/IVP/" . strtoupper($requestId);
                $type = "venue";
                break;
                
            case "church":  // general church pics
                $images_folder = "../data/images/" . strtoupper($requestId);
                $url_images_folder = $domain . "api/data/images/" . strtoupper($requestId);
                $type = "church";
                break;
                
            case "intro":   // main profile picture
                // Process and store image
                $images_folder = "../data/images/" . strtoupper($requestId);
                $url_images_folder = $domain . "api/data/images/" . strtoupper($requestId);
                $type = "intro";
                break;
                
            case "": // Handle file extension for files ending in '.'
            case NULL: // Handle no file extension
                // Do nothing
                break;
        }
        
       // echo $_SERVER['REQUEST_URI'];
        
        if( is_dir($images_folder) === true )
        {
            // directory exists, we now check if it is empty or not
            $isEmpty = dir_is_empty($images_folder);
            
            if (false === $isEmpty) 
            {
                // directory contains files
                
                $dir_files = dirToArray($images_folder);
                
                foreach ($dir_files as $file) {
                    
                    // breakdown filename into parts
                    $file_parts = pathinfo($file);
                    
                    // switch file extension
                    switch(strtolower($file_parts['extension']))
                    {
                        case "jpg":
                        case "jpeg":
                        case "png":
                        case "gif":
                        case "bmp":
                            // Process and store image
                            $file_full_path = $images_folder . '/' . $file;
                            
                            
                            // We check one more time again if the image exists.
                            if (file_exists($file_full_path))
                            {
                                
                                // initialize object
                                $image = new AttendizeEventsImages();
                                
                                $image->name    = $file;
                                $image->url     = $url_images_folder . '/' . $file.'?dl=0';
                                $image->type    = $type;
                                
                                $images_arr[$cntr] = $image;
                                $cntr++;
                            }
                            else
                            {
                                // No data
                            }
                            break;
                            
                        case "": // Handle file extension for files ending in '.'
                        case NULL: // Handle no file extension
                            break;
                    }
                }
                
                if ( 0 < $cntr) 
                {
                    // set response code - 200 OK
                    http_response_code(200);
                    
                    // show learner data in json format
                    echo (GetJsonStatusMsg::getJsonString($images_arr));
                }
                else 
                {
                    http_response_code(404);
                    $errMsg = GetJsonStatusMsg::getJsonErrorString("No Valid Image Found");
                    echo ($errMsg);
                }
            }
            else
            {
                http_response_code(404);
                $errMsg = GetJsonStatusMsg::getJsonErrorString("No Image Found");
                echo ($errMsg);
            }
        }
        else
        {
            http_response_code(404);
            $errMsg = GetJsonStatusMsg::getJsonErrorString("No Image Found");
            echo ($errMsg);
        }
    }
    else
    {
        http_response_code(404);
        $errMsg = GetJsonStatusMsg::getJsonErrorString("No Record Found");
        echo ($errMsg);
    }
    
?>