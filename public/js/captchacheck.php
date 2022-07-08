 <?php session_start();
if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_GET['captcha_code']) != 0){ 
        $msg="Validation code does not match!";// Captcha verification is incorrect.		
}else{// Captcha verification is Correct. Final Code Execute here!	
        $msg=1;		
}
echo $msg;
?>