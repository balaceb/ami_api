<?php

	// required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// get id of product to be edited
    $data = (file_get_contents("php://input"));
	$data_decoded = json_decode($data);	
	
	$return = "Unknown";
	
	
	
	if (null != $data) 
	{
	    $dir = strtoupper($data_decoded->type) ;        // Type contains the category or images we are to store. E.g IVP, general, etc
	    
	    $img_sub_path = "../data/images/IVP/";
	    $img_dir = $img_sub_path . $dir . '/';
	    if( is_dir($img_dir) === false )
	    {
	        mkdir($img_dir);
	        file_put_contents($img_dir.'index.php', "PERMISSION DENIED");
	    }
	    
	    
// 	    $images = $data_decoded->data;
	    
	   // foreach ($images as $image)
	    {
	        $image = $data_decoded->data;
	        // breakdown filename into parts
	        $file_parts = pathinfo($image->name);

	        // switch file extension
	        switch(strtolower($file_parts['extension']))
	        {
	            case "jpg":
	            case "jpeg":
	            case "png":
	            case "gif":
	            case "bmp":
	                // Process and store image
	                $img_storage_path = $img_dir . $image->name;
	                
	                // At the moment we only store the image if it does not already exist.
	                if (!file_exists($img_storage_path))
	                {
	                    // delete file before creating
	                    unlink($img_storage_path);
	                }
	                
	                $img_source_path = $image->path_display;
	                
	                // Store new image
	                file_put_contents($img_storage_path, file_get_contents($img_source_path));
	                
	                $return = "Success";
	                
	                break;
	                
	            case "": // Handle file extension for files ending in '.'
	            case NULL: // Handle no file extension
	                $return = "Error: Invalid Extension";
	                break;
	        }
	    }
	}
	else 
	{
	    // No data
	    $return = "Error: No Data Received";
	}
	
	
	echo $return;

?>

