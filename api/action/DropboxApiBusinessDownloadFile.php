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


function processDropboxApiCallResponse($html)
{
    $url = "https://content.dropboxapi.com/2/sharing/get_shared_link_file";
    $url1 = "https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings";
    $url2 = "https://api.dropboxapi.com/2/sharing/get_file_metadata";
    
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
                    
                    
                    // var_dump ($image);
                    // (curlDropboxApiCreateSharedLink($url1, $image['path_display']));
                    
                    $response = (json_decode(curlDropboxApiGetFileMetaData($url2, $image['path_display'])));
                    
                    $len = (strlen($response->preview_url));
                    $response->preview_url[$len-1] = '1';
                    var_dump($response->preview_url);
                    
                    // We limit the number of images to 100?
                    if(100 == $cntr)
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


function curlDropboxApiListFiles($url, $path="")
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
    
    
    
    processDropboxApiCallResponse($html);
    
}


curlDropboxApiListFiles("https://api.dropboxapi.com/2/files/list_folder", '/Images/Events/IVP/GALLERY');




