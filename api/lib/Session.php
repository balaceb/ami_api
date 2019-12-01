<?php

class Session
{
	 public static function init()
	 {
		if(!isset($_SESSION)) 
		{ 
			//$handler = new MySessionHandler();
			//session_set_save_handler($handler, true);
			session_start();
		}
	 }
	 
	 public static function set($key, $val)
	 {
	     self::init();
	 	 $_SESSION[$key] = $val;
	 }

	 public static function get($key)
	 {
	     self::init();
	 	if (isset($_SESSION[$key])) 
	 	{
	 		return $_SESSION[$key];
	 	} 
	 	else 
	 	{
	 		return false;
	 	}
	 }

	 public static function checkSession()
	 {
	    // self::init(); 
	     $loginSession = self::isLoginSessionFound();
	     
	 	if (self::get("login") == false) 
	 	{
	 		self::destroy();        // Returns the user to the login page after destroying the session
	 		
	 		return false;
	 	}
	 	else
	 	{
	 	    if (true == $loginSession) {
	 	        $t=time();
	 	        if( 3000 < ($t - self::get('lastTime')))
	 	        {
	 	            // User has been inactive for long. Logout
	 	            self::destroy();        // Returns the user to the login page after destroying the session
	 	            
	 	            return false;
	 	        }
	 	        
	 	         // Otherwise, user is active
	 	         return true;
	 	    }
	 	    else
	 	    {
	 	        // No session found for the user
	 	        return false;
	 	    }
	 	}
	 }
	 

    public static function checkAdminSession()
    {
        //self::init();
        $loginSession = self::isLoginSessionFound();
        
	 	if (self::get("login") == true) 
	 	{
	 	    
	 	    if ((self::get("role") == 'admin') && ((true == $loginSession)))
	 	    {
	 	        return true;
	 	    }
	 	    else
	 	    {
	 	        echo "Admin Session Check<br>";
	 	        header('Location: ../index.php');
	 	    }
	 	}
	 	else 
	 	{
	 	    self::destroy();
	 	    return false;
	 	}
	 }

	 public static function checkLogin()
	 {
	     $loginSession = self::isLoginSessionFound();
	     
	    if ((self::get('login') == false) || (false == $loginSession)) 
	 	{
	 	    // This can be troublesome for pages with live update. When timeout occurs when a section of the page is being updated, it doesn't switch to the login page smoothly but mixes with the page refresh and the result is a mess.
            // header("Location:../login.php"); 
	 	    header("Refresh:0; url=../login.php");
	 	}
	 	else 
	 	{
	 	    //
	 	}
	 	return true;
	 }

    public static function checkAdminLogin()
    {
	 	//self::init();
	 	
	 	if(true == self::checkLogin())
	 	{
            if (self::get("role") == 'admin') 
            {
               return true; 
            }
            else 
            {
                // if it reaches here, user is logged in but not admin. A 'Go Back Link will be shown'
                echo  "Unauthorized Access!!  ";
                echo "<a href='javascript:history.go(-1)'>Go Back</a>";
                exit();     // So that the html that follows will not be shown. User will not see the page, only the above link echoed
            }
	 	}
	 	else 
	 	{
	 	    // Do nothing
	 	}
	 }

	 
	 public static function isLoginSessionFound()
	 {
	     self::init();
	     
	     require_once '../lib/Database.php';
	     $email = '';
	     $returnStatus = false;
	     if ( (isset($_SESSION['email'])) && (isset($_SESSION[LMS_LOGIN_SECRET])) ) {
	         $email = $_SESSION['email'];
	         $secret_session = $_SESSION[LMS_LOGIN_SECRET];
	         $query = "SELECT * from tbl_login_session WHERE email='$email'";
	         $db = new Database();
	         
	         $result = $db->select($query);
	         
	         if (false != $result)
	         {
	             $row = mysqli_fetch_assoc($result);
	             
	             $secret_db = $row['login_code'];
	             
	             if ($secret_db === $secret_session) {
	                 $returnStatus = true;
	             }
	         }
	     }
	     
	     return $returnStatus;
	 }
	 
	 
	 public static function destroy()
	 {
	     self::init();
        //session_unset();
        session_destroy();
        //session_write_close();
        
        // We refresh before redirecting because it was noticed that if automatic logout occurs when data is being updated on the page, both pages load created a bad page.
        self::checkLogin();
        header("Refresh:0; url=../login.php");
	 }
}

?>