
$(function(){
	

	// Test Enrolled learners - Read
	$.ajax({
        url: 'api/get/get_enrolled.php',	// ?id=412645316451
        type: 'get',
        contentType:"application/json; charset=utf-8",		// This is also set in the php script and is not required again here
        dataType: 'JSON',					// We either set the data type here or in the php script using  header("Content-Type: application/json; charset=UTF-8");
        success: function(response){
        	var json_value;
            var len = response.length;
            
//            alert(response.message.length);
            
            $('#enrolledDiv').html("");
            for (var i in response.message) 
            {
                // alert(response[i]);
            	$('#enrolledDiv').append("<b>No: " + i + "<b><br>");
            	$('#enrolledDiv').append("ID: " + response.message[i].id + " <br>Registration ID: " + response.message[i].reg_id);
            	$('#enrolledDiv').append("<br>Session ID: " + response.message[i].session_id + " <br>Enrolled ID: " + response.message[i].enroll_id);
            	$('#enrolledDiv').append("<br>Status: " + response.message[i].status + "<br>Enrollment Date: " + response.message[i].enroll_date + "<br>Enrollment Letter: " + response.message[i].enroll_letter);
            	$('#enrolledDiv').append("<br><hr><br>");
            }
        }
    });
	
	// Test Assessed learners - Read
	$.ajax({
        url: 'api/get/get_assessed.php',	// ?id=412645316451
        type: 'get',
        contentType:"application/json; charset=utf-8",		// This is also set in the php script and is not required again here
        dataType: 'JSON',					// We either set the data type here or in the php script using  header("Content-Type: application/json; charset=UTF-8");
        success: function(response){
        	var json_value;
            var len = response.length;
            
//            alert(response.message.length);
            $('#assessedDiv').html("");
            for (var i in response.message) 
            {
            	$('#assessedDiv').append("<b>No: " + i + "<b><br>");
            	$('#assessedDiv').append("ID: " + response.message[i].id + " <br>Enrolled ID: " + response.message[i].enroll_id + " <br>Assessor: " + response.message[i].assessor);
            	$('#assessedDiv').append("<br>Module: " + response.message[i].module + " <br>Script: " + response.message[i].script);
            	$('#assessedDiv').append("<br>Moderate: " + response.message[i].moderate + "<br>Competence: " + response.message[i].competence + "<br>Date: " + response.message[i].date);
            	$('#assessedDiv').append("<br><hr><br>");
            }
        }
    });
	
	
	
	
	
	// Test Enrolled learners - Read
	
	var enrollObject = new Object();
	
	enrollObject.enroll_id        = "BalBal68415412";
	enrollObject.enroll_date      = "01-01-2020";
	enrollObject.enroll_letter    = "http://www.orimi.com/pdf-test.pdf1";
	enrollObject.session_id       = "EC-5241-4651-AF-01";
	enrollObject.reg_id           = "412645316453";
	enrollObject.status           = "facilitated";
    
	
	$('#my-form').submit( function(e)
	{
		var url = 'api/update/update_enrolled.php';
		var msg = JSON.stringify(enrollObject);
		
		//postAjax(url, msg, function(data){alert(data);});
		$.ajax({
	        url: 'api/update/update_enrolled.php',	
	        data: JSON.stringify(enrollObject), //JSON.stringify(enrollObject),
	        type: 'POST',
	        contentType:"application/json; charset=utf-8",		// This is also set in the php script and is not required again here
	        dataType: 'json',									// We either set the data type here or in the php script using  header("Content-Type: application/json; charset=UTF-8");
	        processData: false,
	        success: function(data)
	        {
	            alert(data.message);
	        },
	        failure: function(errMsg) {
	            alert(errMsg);
	        }
	    });
	});
	
	
	function postAjax(url, data, success) {
	    var params = typeof data == 'string' ? data : Object.keys(data).map(
	            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	        ).join('&');

	    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	    xhr.open('POST', url);
	    xhr.onreadystatechange = function() {
	        if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
	    };
	    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    xhr.send(params);
	    return xhr;
	}
	
	
	
});


