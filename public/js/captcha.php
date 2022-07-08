<?php
//echo "inside";
	session_start();
	include_once("phptextClass.php");	
//	
//	/*create class object*/
	$phptextObj = new phptextClass();	
//	/*phptext function to genrate image with text*/
	$phptextObj->phpcaptcha('#fff','#162453',120,40,0,0);	
 ?>