<?php

 function session_isset($redirectUrl = "/cms/login"){

 	@session_start();
    if(!isset($_SESSION['username']) && !isset($_SESSION['access_level']))
    {
         redirect($redirectUrl);
    }
    
    return true;
}
