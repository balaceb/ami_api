<?php

	// required headers
    header("Access-Control-Allow-Origin: *");
   // header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	// get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
		
	// Get from db?
 	$aToken = "n0ZfoO5DlNwAAAAAAAAIlzum3wX5y4KyaxDPK0oBlGsVDJomg35-NEKO6EwdFOpk";
// 	$aToken = "6w4TtuZJNjcAAAAAAAAk7lS8jlXC_JSS_jeqWxDLAng9UqI29OcU-4MSMn64jSnd"; // eric_
	
	$cookieId = "id_" . (string)(time() + rand(10000, 100000000)); 
	$_COOKIE[$cookieId] = "";
	
	
?>

	
	<!-- JS-Library to run Dropbox APIs -->
	<script src="../../js/dropbox/Dropbox-sdk.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/core.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
		
	<!-- Calls to Dropbox API using Dropbox-sdk library -->
	<script>

		// For IVP
		function getIvpEventsImages()
		{
			 
			var ACCESS_TOKEN = "<?php echo ($aToken); ?>"; 

			var dbx = new Dropbox.Dropbox({ accessToken: ACCESS_TOKEN });
			console.log('dbx', dbx);

			
			
			// ToDo: Update folder path to point to actual pictures of event
			dbx.filesListFolder({path: '/Family/Baby/Keneric/Pics'})
// 			dbx.filesListFolder({path: '/AMI Johannesburg/Images/Events/IVP/GALLERY'})
			.then(function(response) {
			  console.log('response', response);
			  displayFiles(response.entries, 'IVP');
			  console.log(response);
			})
			.catch(function(error) {
			  console.error(error);

			  <?php
	    			$file = '../data/error_log.txt';
	    			// The new person to add to the file
	    			$log_msg = "Error communicating with Dropbox at: " . date("D M d, Y G:i") . "\n";
	    			// Write the contents to the file, 
	    			// using the FILE_APPEND flag to append the content to the end of the file
	    			// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
	    			file_put_contents($file, $log_msg, FILE_APPEND | LOCK_EX);
    			?>
			});
		}

        function displayFiles(files, type) 
        {
			var ACCESS_TOKEN = "<?php echo ($aToken); ?>"; 

			var dbx = new Dropbox.Dropbox({ accessToken: ACCESS_TOKEN });

			var url_only = " ";

			for (var i = 0; i < files.length; i++) 
            {
					var imageId = files[i].id;
					//var imageName = files[i].name;
					var clientModified = files[i].client_modified;
					var serverModified = files[i].server_modified;
					var imageSize = files[i].size;
	                var imageIsDownloadable = files[i].is_downloadable;
	                
				getSharedLinkPromise = new Promise(function(resolve, reject) {

					var url_only = dbx.sharingCreateSharedLink({path: files[i].path_display})
					.then(function(response) {
					  
					  if((response.error_summary !== undefined))
					  {
						// shared link already created
						
					  }
					  else
					  {
						  // shared link created
						 resolve([response.url, response.name]);
						 console.log('file_response1', response);
					  }

					})
					.catch(function(error) {
						  <?php
				    			$file = '../data/error_log.txt';
				    			// The new person to add to the file
				    			$log_msg = "Error communicating with Dropbox at: " . date("D M d, Y G:i") . "\n";
				    			// Write the contents to the file, 
				    			// using the FILE_APPEND flag to append the content to the end of the file
				    			// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
				    			file_put_contents($file, $log_msg, FILE_APPEND | LOCK_EX);
			    			?>
					});
					
				});
				
				

					getSharedLinkPromise.then(function(value) {
						

						url_only = value[0].split('?');
    	                
    	                var download_url = url_only[0] + "?dl=1";		// make image downloadable so that it can be downloaded and stored on server.

    	                // We split the url to get the filename only. For some reason, the files[i].name keeps giving the name of the last element only. It appears the files array cannot be accessed here.
   	                 	var url_parts = url_only[0].split('/');

   						var imageName = url_parts[url_parts.length-1];

   						console.log('imageSize', imageName);
    					
    	                // alert(download_url);
    	                
						var dataObject = {"type":type, 
    	                "data":[
    	                	  {"name":imageName, "path_display":download_url, "size":imageSize, "is_downloadable":imageIsDownloadable, "client_modified":clientModified, "server_modified":serverModified},
    	                	]};
	                	
			    		return  $.ajax({
			      	        url: 'saveIvpImages.php',	
			      	        data: JSON.stringify(dataObject), 
			      	        type: 'POST',
			      	        async: false,
			      	        contentType:"application/json; charset=utf-8",		// This is also set in the php script and is not required again here
			      	        dataType: 'json',									// We either set the data type here or in the php script using  header("Content-Type: application/json; charset=UTF-8");
			      	        processData: false,
			      	      beforeSend: function() {
			      	        //alert('before');
			      	    },
    			          complete: function() {
    			        	  //alert('complete');
    			          },
			      	        success: function(data)
			      	        {
			      	            // alert(data);
			      	        },
			      	        failure: function(errMsg) {
			      	        	<?php
			      	    			$file = '../data/error_log.txt';
			      	    			// The new person to add to the file
			      	    			$log_msg = "Failed Getting shared link of image at: " . date("D M d, Y G:i") . "\n";
			      	    			// Write the contents to the file, 
			      	    			// using the FILE_APPEND flag to append the content to the end of the file
			      	    			// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
			      	    			file_put_contents($file, $log_msg, FILE_APPEND | LOCK_EX);
		      	    			?>
			      	        }
			      	      ,
			      	    error: function(xhr) { // if error occured
			      	        // alert(xhr.statusText + xhr.responseText);

			      	        	// Log error

			      	    	     <?php
			      	    			$file = '../data/error_log.txt';
			      	    			// The new person to add to the file
			      	    			$person = "Error Getting shared link of image at: " . date("D M d, Y G:i") . "\n";
			      	    			// Write the contents to the file, 
			      	    			// using the FILE_APPEND flag to append the content to the end of the file
			      	    			// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
			      	    			file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
		      	    			?>
			      	    	}
			      	    });
				      	    
					  	console.log("Hurray I got this phone as a gift ", JSON.stringify(value));
					});
				getSharedLinkPromise.catch(function(reason) {
					  console.log("Mom coudn't buy me the phone because ", reason);
					});
				getSharedLinkPromise.finally(function() {
					  console.log(
					    "Irrespecitve of whether my mom can buy me a phone or not, I still love her"
					  );
					});

				console.log("helhel2", getSharedLinkPromise);

            }
    	}



    	// Call functions to get images
    	getIvpEventsImages();
    	
  </script>


