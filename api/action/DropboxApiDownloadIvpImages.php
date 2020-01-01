<?php
/*
 * This file demonstrates how to use dropbox business API to read/download files on a business account.
 * To do this:
 *   - Read the team folder's ID using https://api.dropboxapi.com/2/team/namespaces/list business API.
 *     This will list all folders available to the team together with meta data of those foders. Folders here are called namespaces.
 *     With this folder ID and know path of exact file to be read, downloaded, etc can be obtained relative to the parent shared team folder.
 *     With this ID and path, we can user the Dropbox user API endpoints to manipulate files on the business account or team files.
 *     
 * */


$domain_url = 'localhost/aser/others/learning/test_api/api/action/';

$whitelist = array(
    '127.0.0.1',
    '::1'
);

if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist))
{
    $domain_url = 'https://www.en3ticket.com/api/api/action/';
}


// Save file to disk
function curlSaveImageOnServer($url='', $data='')
{
    // Create a new cURL resource
    $curl = curl_init();
    
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    
    
    // Set the file URL to fetch through cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    
    
    // Return the actual result of the curl result instead of success code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    
    curl_setopt($curl, CURLOPT_POST, 1);
    
    curl_setopt($curl, CURLOPT_POSTFIELDS,  ($data));
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array (
        "Expect: 100-continue",
        "Content-Type: application/json; charset=UTF-8",
    ));
    
    
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    
    // var_dump($url);
    
    // Check if any error has occurred
    if (curl_errno($curl))
    {
         echo 'cURL error: ' . curl_error($curl);
    }
    else
    {
        // cURL executed successfully
       // $json_result_string = json_encode(curl_getinfo($curl), JSON_PRETTY_PRINT);
    }
    
    // close cURL resource to free up system resources
    curl_close($curl);
    
    return ($html);		// created shared link json object
    
}


function curlDropboxApiGetSharedLink($url='https://content.dropboxapi.com/2/sharing/get_shared_link_file', $path="")
{
    // Create a new cURL resource
    $curl = curl_init();
    
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    
    // Set the file URL to fetch through cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    
    
    // Return the actual result of the curl result instead of success code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_setopt($curl, CURLOPT_POST, 1);
    $data = array('url' => $path);
    $data_json = json_encode($data, JSON_FORCE_OBJECT);
    
    //curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data, JSON_FORCE_OBJECT));
    
    $header_opts = array('.tag' => 'namespace_id', 'namespace_id' => '6699120048');
    
    $header_opts_json = json_encode($header_opts, JSON_FORCE_OBJECT);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array (
        "Content-Type: text/plain; charset=utf-8",
        "Expect: 100-continue",
        "Content-Type: application/json",
        "Authorization: Bearer 6w4TtuZJNjcAAAAAAAAlBoqETx7dhF-F3At-0pNHqyA5wLOXEl364YdSDbgOxeCu",
        /// "Authorization: Bearer m7von9IuBxAAAAAAAATnwMsFsewncJm4pnPo58wYXPdEXK3fWCHLNkoQGqOelrvq",
        'Dropbox-API-Path-Root: ' . $header_opts_json,
        'Dropbox-API-Arg: ' . $data_json,
    ));
    
    
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    
    
    // Check if any error has occurred
    if (curl_errno($curl))
    {
        // echo 'cURL error: ' . curl_error($curl);
    }
    else
    {
        // cURL executed successfully
        $json_string = json_encode(curl_getinfo($curl), JSON_PRETTY_PRINT);
        // var_dump(($json_string));
    }
    
    // close cURL resource to free up system resources
    curl_close($curl);
    
    
    
    return ($html);
    
}


function curlDropboxApiCreateSharedLink($url='hhttps://api.dropboxapi.com/2/sharing/create_shared_link_with_settings', $path="")
{
    // Create a new cURL resource
    $curl = curl_init();
    
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    
    // Set the file URL to fetch through cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    
    
    // Return the actual result of the curl result instead of success code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    
    curl_setopt($curl, CURLOPT_POST, 1);
    $data = array('path' => $path);
    $data_json = json_encode($data, JSON_FORCE_OBJECT);
    
    curl_setopt($curl, CURLOPT_POSTFIELDS,  ($data_json));
    
    $header_opts = array('.tag' => 'namespace_id', 'namespace_id' => '6699120048');
    
    $header_opts_json = json_encode($header_opts, JSON_FORCE_OBJECT);
    
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array (
        //"Content-Type: text/plain; charset=utf-8",
        "Expect: 100-continue",
        "Content-Type: application/json",
        "Authorization: Bearer 6w4TtuZJNjcAAAAAAAAlBoqETx7dhF-F3At-0pNHqyA5wLOXEl364YdSDbgOxeCu",
        /// "Authorization: Bearer m7von9IuBxAAAAAAAATnwMsFsewncJm4pnPo58wYXPdEXK3fWCHLNkoQGqOelrvq",
        'Dropbox-API-Path-Root: ' . $header_opts_json,
    ));
    
    
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    
    
    // Check if any error has occurred
    if (curl_errno($curl))
    {
        // echo 'cURL error: ' . curl_error($curl);
    }
    else
    {
        // cURL executed successfully
        $json_string = json_encode(curl_getinfo($curl), JSON_PRETTY_PRINT);
        // var_dump(($json_string));
    }
    
    // close cURL resource to free up system resources
    curl_close($curl);
    
    
    
    return ($html);		// created shared link json object
    
}


// Get file metadata. This includes create shared link action if the shared link does not already exist
function curlDropboxApiGetFileMetaData($url='https://api.dropboxapi.com/2/sharing/get_file_metadata', $path="")
{
    // Create a new cURL resource
    $curl = curl_init();
    
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    
    // Set the file URL to fetch through cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    
    
    // Return the actual result of the curl result instead of success code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    
    curl_setopt($curl, CURLOPT_POST, 1);
    
    // data includes action to create shared link if it does not exist
    $data = array('file' => $path);
    $data_json = json_encode($data, JSON_FORCE_OBJECT);
    
    curl_setopt($curl, CURLOPT_POSTFIELDS,  ($data_json));
    
    $header_opts = array('.tag' => 'namespace_id', 'namespace_id' => '6699120048');
    
    $header_opts_json = json_encode($header_opts, JSON_FORCE_OBJECT);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array (
        "Expect: 100-continue",
        "Content-Type: application/json",
        "Authorization: Bearer 6w4TtuZJNjcAAAAAAAAlBoqETx7dhF-F3At-0pNHqyA5wLOXEl364YdSDbgOxeCu",
        'Dropbox-API-Path-Root: ' . $header_opts_json,
    ));
    
    
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    
    
    // Check if any error has occurred
    if (curl_errno($curl))
    {
        // echo 'cURL error: ' . curl_error($curl);
    }
    else
    {
        // cURL executed successfully
        $json_string = json_encode(curl_getinfo($curl), JSON_PRETTY_PRINT);
        // var_dump(($json_string));
    }
    
    // close cURL resource to free up system resources
    curl_close($curl);
    
    return ($html);		// created shared link json object
    
}


function processDropboxApiCallResponse($html, $type)
{
    
    $url = "https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings";
    
    global $domain_url;
    
    $images = (json_decode($html, true));
    foreach ($images as $key => $value)
    {
        
        if('entries' === $key)
        {
            $cntr = 0;
            
            foreach($value as $image)
            {
                if('file' === $image['.tag'])
                {
                    $cntr = $cntr +1;
                    
                    $response = (json_decode(curlDropboxApiCreateSharedLink($url, $image['path_display'])));
                                 
                                   
                    $image_url = '';
                    $image_name = '';
                    if(isset($response->error))
                    {
                        $image_url = $response->error->shared_link_already_exists->metadata->url;
                        $image_name = $response->error->shared_link_already_exists->metadata->name;
                        var_dump($image_url);
                    }
                    else
                    {
                        $image_url = $response->url;
                        $image_name = $response->name;
                        var_dump($image_url);
                    }
                    $len = (strlen($image_url));
                    $image_url[$len-1] = '1';
                        
                        
                        
                    
                    // send new file info to saveIvpImages.php so it can be saved on server
                    $data = array(
                        'name' => $image_name,
                        'filename' => $image_name,
                        'path_display' => $image_url,   // we use $response->preview_url cuz we have already prepared the link for download
                    );
                    
                    $data_desc = array('type' => $type, 'data' => $data);
                    $data_json = json_encode($data_desc, JSON_FORCE_OBJECT);
                    $result = curlSaveImageOnServer($domain_url . 'saveIvpImages.php', $data_json);
                    
                    if( ('Success' != $result) && ('success' != $result) && ('Ok' != $result) && ('OK' != $result) )
                    {
                        // Log error
                        $file = '../data/error_log.txt';
                        // The new person to add to the file
                        $person = "Error Getting shared link of image at: " . date("D M d, Y G:i") . "\n";
                        // Write the contents to the file,
                        // using the FILE_APPEND flag to append the content to the end of the file
                        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
                        file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
                    }
                    else
                    {
                        // Do nothing
                    }
                    
                    
                    // We limit the number of images to 100?
                    if(50 == $cntr)
                    {
                        break;
                    }
                    else
                    {
                        // Do nothing
                    }
                }
                else
                {
                    // Do nothing
                }
                
            }
            
            var_dump($cntr);
        }
        
        
    }
}


function curlDropboxApiListFiles($url, $path="", $type="")
{
    // Create a new cURL resource
    $curl = curl_init();
    
    if (!$curl) {
        die("Couldn't initialize a cURL handle");
    }
    
    // Set the file URL to fetch through cURL
    // curl_setopt($curl, CURLOPT_URL, "https://api.dropboxapi.com/2/team/namespaces/list");
    curl_setopt($curl, CURLOPT_URL, $url);
    
    
    // Return the actual result of the curl result instead of success code
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Do not check the SSL certificates
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_setopt($curl, CURLOPT_POST, 1);
    $data = array('path' => $path);
    curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data, JSON_FORCE_OBJECT));
    
    $header_opts = array('.tag' => 'namespace_id', 'namespace_id' => '6699120048');
    
    $header_opts_json = json_encode($header_opts, JSON_FORCE_OBJECT);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array (
        "Content-Type: text/xml; charset=utf-8",
        "Expect: 100-continue",
        "Content-Type: application/json",
        "Authorization: Bearer 6w4TtuZJNjcAAAAAAAAlBoqETx7dhF-F3At-0pNHqyA5wLOXEl364YdSDbgOxeCu",
        /// "Authorization: Bearer m7von9IuBxAAAAAAAATnwMsFsewncJm4pnPo58wYXPdEXK3fWCHLNkoQGqOelrvq",
        'Dropbox-API-Path-Root: ' . $header_opts_json
    ));
    
    
    
    
    // Fetch the URL and save the content in $html variable
    $html = curl_exec($curl);
    
    
    // Check if any error has occurred
    if (curl_errno($curl))
    {
        // echo 'cURL error: ' . curl_error($curl);
    }
    else
    {
        // cURL executed successfully
        $json_string = json_encode(curl_getinfo($curl), JSON_PRETTY_PRINT);
        // var_dump(($json_string));
    }
    
    // close cURL resource to free up system resources
    curl_close($curl);
    
    
    
    processDropboxApiCallResponse($html, $type);
    
}

set_time_limit (1600);

curlDropboxApiListFiles("https://api.dropboxapi.com/2/files/list_folder", '/Images/Events/IVP/GALLERY', 'gallery');

curlDropboxApiListFiles("https://api.dropboxapi.com/2/files/list_folder", '/Images/Events/IVP/VENUE', 'venue');


