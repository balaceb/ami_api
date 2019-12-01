<?php 
    class ApiStatus
    {
        public $message;
    }
    
    class GetJsonStatusMsg 
    {
        public static function getJsonErrorString($errMsg) 
        {
            $err = new ApiStatus();
            $err->message =  "{error: ".$errMsg."}";
            
            return json_encode($err, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
        
        
        public static function getJsonString($msg) 
        {
            $returnMsg = new ApiStatus();
            //$returnMsg->msg = array();
            $returnMsg->message = $msg;
            return json_encode($returnMsg, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }
?>