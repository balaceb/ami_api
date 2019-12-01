<?php
/**
* Format Class
*/
class Format{
	public function formatDate($date){
		return date('F j, Y, g:i a', strtotime($date));
	}

	public function textShorten($text, $limit = 400){
		$text = $text. " ";
		$text = substr($text, 0, $limit);
		$text = substr($text, 0, strrpos($text, ' '));
		$text = $text.".....";
		return $text;
	}

	public function validation($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		$data = filter_var($data, FILTER_SANITIZE_STRING);
		return $data;
	}

	public function title(){
		$path = $_SERVER['SCRIPT_FILENAME'];
		$title = basename($path, '.php');
		//$title = str_replace('_', ' ', $title);
		if ($title == 'index') {
			$title = 'home';
		}elseif ($title == 'contact') {
			$title = 'contact';
		}
		return $title = ucfirst($title);
	}
	
	public function simple_unicode_decode($str) {
	    $str1=str_ireplace("u0001","?",$str);
	    $str1=str_ireplace("u0002","?",$str1);
	    $str1=str_ireplace("u0003","?",$str1);
	    $str1=str_ireplace("u0004","?",$str1);
	    $str1=str_ireplace("u0005","?",$str1);
	    $str1=str_ireplace("u0006","?",$str1);
	    $str1=str_ireplace("u0007","•",$str1);
	    $str1=str_ireplace("u0008","?",$str1);
	    $str1=str_ireplace("u0009","?",$str1);
	    $str1=str_ireplace("u000A","?",$str1);
	    $str1=str_ireplace("u000B","?",$str1);
	    $str1=str_ireplace("u000C","?",$str1);
	    $str1=str_ireplace("u000D","?",$str1);
	    $str1=str_ireplace("u000E","?",$str1);
	    $str1=str_ireplace("u000F","¤",$str1);
	    $str1=str_ireplace("u0010","?",$str1);
	    $str1=str_ireplace("u0011","?",$str1);
	    $str1=str_ireplace("u0012","?",$str1);
	    $str1=str_ireplace("u0013","?",$str1);
	    $str1=str_ireplace("u0014","¶",$str1);
	    $str1=str_ireplace("u0015","§",$str1);
	    $str1=str_ireplace("u0016","?",$str1);
	    $str1=str_ireplace("u0017","?",$str1);
	    $str1=str_ireplace("u0018","?",$str1);
	    $str1=str_ireplace("u0019","?",$str1);
	    $str1=str_ireplace("u001A","?",$str1);
	    $str1=str_ireplace("u001B","?",$str1);
	    $str1=str_ireplace("u001C","?",$str1);
	    $str1=str_ireplace("u001D","?",$str1);
	    $str1=str_ireplace("u001E","?",$str1);
	    $str1=str_ireplace("u001F","?",$str1);
	    $str1=str_ireplace("u0020"," ",$str1);
	    $str1=str_ireplace("u0021","!",$str1);
	    $str1=str_ireplace("u0022","\"",$str1);
	    $str1=str_ireplace("u0023","#",$str1);
	    $str1=str_ireplace("u0024","$",$str1);
	    $str1=str_ireplace("u0025","%",$str1);
	    $str1=str_ireplace("u0026","&",$str1);
	    $str1=str_ireplace("u0027","'",$str1);
	    $str1=str_ireplace("u0028","(",$str1);
	    $str1=str_ireplace("u0029",")",$str1);
	    $str1=str_ireplace("u002A","*",$str1);
	    $str1=str_ireplace("u002B","+",$str1);
	    $str1=str_ireplace("u002C",",",$str1);
	    $str1=str_ireplace("u002D","-",$str1);
	    $str1=str_ireplace("u002E",".",$str1);
	    $str1=str_ireplace("u2026","…",$str1);
	    $str1=str_ireplace("u002F","/",$str1);
	    $str1=str_ireplace("u0030","0",$str1);
	    $str1=str_ireplace("u0031","1",$str1);
	    $str1=str_ireplace("u0032","2",$str1);
	    $str1=str_ireplace("u0033","3",$str1);
	    $str1=str_ireplace("u0034","4",$str1);
	    $str1=str_ireplace("u0035","5",$str1);
	    $str1=str_ireplace("u0036","6",$str1);
	    $str1=str_ireplace("u0037","7",$str1);
	    $str1=str_ireplace("u0038","8",$str1);
	    $str1=str_ireplace("u0039","9",$str1);
	    $str1=str_ireplace("u003A",":",$str1);
	    $str1=str_ireplace("u003B",";",$str1);
	    $str1=str_ireplace("u003C","<",$str1);
	    $str1=str_ireplace("u003D","=",$str1);
	    $str1=str_ireplace("u003E",">",$str1);
	    $str1=str_ireplace("u2264","=",$str1);
	    $str1=str_ireplace("u2265","=",$str1);
	    $str1=str_ireplace("u003F","?",$str1);
	    $str1=str_ireplace("u0040","@",$str1);
	    $str1=str_ireplace("u0041","A",$str1);
	    $str1=str_ireplace("u0042","B",$str1);
	    $str1=str_ireplace("u0043","C",$str1);
	    $str1=str_ireplace("u0044","D",$str1);
	    $str1=str_ireplace("u0045","E",$str1);
	    $str1=str_ireplace("u0046","F",$str1);
	    $str1=str_ireplace("u0047","G",$str1);
	    $str1=str_ireplace("u0048","H",$str1);
	    $str1=str_ireplace("u0049","I",$str1);
	    $str1=str_ireplace("u004A","J",$str1);
	    $str1=str_ireplace("u004B","K",$str1);
	    $str1=str_ireplace("u004C","L",$str1);
	    $str1=str_ireplace("u004D","M",$str1);
	    $str1=str_ireplace("u004E","N",$str1);
	    $str1=str_ireplace("u004F","O",$str1);
	    $str1=str_ireplace("u0050","P",$str1);
	    $str1=str_ireplace("u0051","Q",$str1);
	    $str1=str_ireplace("u0052","R",$str1);
	    $str1=str_ireplace("u0053","S",$str1);
	    $str1=str_ireplace("u0054","T",$str1);
	    $str1=str_ireplace("u0055","U",$str1);
	    $str1=str_ireplace("u0056","V",$str1);
	    $str1=str_ireplace("u0057","W",$str1);
	    $str1=str_ireplace("u0058","X",$str1);
	    $str1=str_ireplace("u0059","Y",$str1);
	    $str1=str_ireplace("u005A","Z",$str1);
	    $str1=str_ireplace("u005B","[",$str1);
	    $str1=str_ireplace("u005C","\\",$str1);
	    $str1=str_ireplace("u005D","]",$str1);
	    $str1=str_ireplace("u005E","^",$str1);
	    $str1=str_ireplace("u005F","_",$str1);
	    $str1=str_ireplace("u0060","`",$str1);
	    $str1=str_ireplace("u0061","a",$str1);
	    $str1=str_ireplace("u0062","b",$str1);
	    $str1=str_ireplace("u0063","c",$str1);
	    $str1=str_ireplace("u0064","d",$str1);
	    $str1=str_ireplace("u0065","e",$str1);
	    $str1=str_ireplace("u0066","f",$str1);
	    $str1=str_ireplace("u0067","g",$str1);
	    $str1=str_ireplace("u0068","h",$str1);
	    $str1=str_ireplace("u0069","i",$str1);
	    $str1=str_ireplace("u006A","j",$str1);
	    $str1=str_ireplace("u006B","k",$str1);
	    $str1=str_ireplace("u006C","l",$str1);
	    $str1=str_ireplace("u006D","m",$str1);
	    $str1=str_ireplace("u006E","n",$str1);
	    $str1=str_ireplace("u006F","o",$str1);
	    $str1=str_ireplace("u0070","p",$str1);
	    $str1=str_ireplace("u0071","q",$str1);
	    $str1=str_ireplace("u0072","r",$str1);
	    $str1=str_ireplace("u0073","s",$str1);
	    $str1=str_ireplace("u0074","t",$str1);
	    $str1=str_ireplace("u0075","u",$str1);
	    $str1=str_ireplace("u0076","v",$str1);
	    $str1=str_ireplace("u0077","w",$str1);
	    $str1=str_ireplace("u0078","x",$str1);
	    $str1=str_ireplace("u0079","y",$str1);
	    $str1=str_ireplace("u007A","z",$str1);
	    $str1=str_ireplace("u007B","{",$str1);
	    $str1=str_ireplace("u007C","|",$str1);
	    $str1=str_ireplace("u007D","}",$str1);
	    $str1=str_ireplace("u02DC","˜",$str1);
	    $str1=str_ireplace("u007E","~",$str1);
	    $str1=str_ireplace("u007F","",$str1);
	    $str1=str_ireplace("u00A2","¢",$str1);
	    $str1=str_ireplace("u00A3","£",$str1);
	    $str1=str_ireplace("u00A4","¤",$str1);
	    $str1=str_ireplace("u20AC","€",$str1);
	    $str1=str_ireplace("u00A5","¥",$str1);
	    $str1=str_ireplace("u0026quot;","\"",$str1);
	    $str1=str_ireplace("u0026gt;",">",$str1);
	    $str1=str_ireplace("u0026lt;",">",$str1);
	    return $str1;
	}

}
?>